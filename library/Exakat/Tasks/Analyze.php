<?php
/*
 * Copyright 2012-2017 Damien Seguy – Exakat Ltd <contact(at)exakat.io>
 * This file is part of Exakat.
 *
 * Exakat is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Exakat is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Exakat.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://exakat.io/>.
 *
*/


namespace Exakat\Tasks;

use Exakat\Analyzer\Analyzer;
use Exakat\Config;
use Exakat\Exceptions\DependsOnMustReturnArray;
use Exakat\Exceptions\NoSuchAnalyzer;
use Exakat\Exceptions\NoSuchProject;
use Exakat\Exceptions\NoSuchThema;
use Exakat\Exceptions\ProjectNeeded;
use Exakat\Phpexec;
use ProgressBar\Manager as ProgressBar;

class Analyze extends Tasks {
    const CONCURENCE = self::ANYTIME;

    public function run() {
        $project = $this->config->project;
        
        if ($project == 'default') {
            throw new ProjectNeeded($project);
        }

        if (!file_exists($this->config->projects_root.'/projects/'.$project)) {
            throw new NoSuchProject($project);
        }

        $this->checkTokenLimit();
        $begin = microtime(true);

        Analyzer::$gremlinStatic = $this->gremlin;
        
        // Take this before we clean it up
        $rows = $this->datastore->getRow('analyzed');
        $analyzed = array();
        foreach($rows as $row) {
            $analyzed[$row['analyzer']] = $row['counts'];
        }

        if ($this->config->program !== null) {
            $analyzer = $this->config->program;
            if (Analyzer::getClass($analyzer)) {
                $analyzers_class = array($analyzer);
            } else {
                throw new NoSuchAnalyzer($analyzer);
            }
        } elseif (is_string($this->config->thema)) {
            $thema = $this->config->thema;

            if (!$analyzers_class = Analyzer::getThemeAnalyzers($thema)) {
                throw new NoSuchAnalyzer($thema);
            }

            $this->datastore->addRow('hash', array($this->config->thema => count($analyzers_class) ) );
        } else {
            die( "");
        }

        $this->log->log("Analyzing project $project");
        $this->log->log("Runnable analyzers\t".count($analyzers_class));

        if ($this->config->noDependencies) {
            $dependencies2 = $analyzers_class;
        } else {
            $dependencies = array();
            $dependencies2 = array();
            foreach($analyzers_class as $a) {
                $d = Analyzer::getInstance($a);
                $this->configName = str_replace('/', '_', $a);
                $d = $d->dependsOn();
                if (!is_array($d)) {
                    throw new DependsOnMustReturnArray(get_class($this));
                }
                if (empty($d)) {
                    $dependencies2[] = $a;
                } else {
                    $diff = array_diff($d, $dependencies2);
                    if (empty($diff)) {
                        $dependencies2[] = $a;
                    } else {
                        $dependencies[$a] = $diff;
                    }
                }
            }

            $c = count($dependencies) + 1;
            while(!empty($dependencies) && $c > count($dependencies)) {
                $c = count($dependencies);
                foreach($dependencies as $a => &$d) {
                    $diff = array_diff($d, $dependencies2);

                    foreach($diff as $k => $v) {
                        if (!isset($dependencies[$v])) {
                            $x = Analyzer::getInstance($v);
                            if ($x === null) {
                                display( "No such dependency as '$v'. Ignoring\n");
                                continue;
                            }
                            $dep = $x->dependsOn();
                            if (count($dep) == 0) {
                                $dependencies2[] = $v;
                                ++$c;
                            } else {
                                $dependencies[$v] = $dep;
                                $c += count($dep) + 1;
                            }
                        } elseif (count($dependencies[$v]) == 0) {
                            $dependencies2[] = $v;
                            unset($diff[$k]);
                        }
                    }
        
                    if (empty($diff)) {
                        $dependencies2[] = $a;
                        unset($dependencies[$a]);
                    } else {
                        $d = $diff;
                    }
                }
                unset($d);
            }

            assert(empty($dependencies), 
                   "Dependencies depending on each other : can't finalize. Aborting\n".
                   print_r($dependencies, true));
        }

        $total_results = 0;
        $Php = new Phpexec($this->config->version);

        $progressBar = new Progressbar(0, count($dependencies2) + 1, exec('tput cols'));
        
        foreach($dependencies2 as $analyzer_class) {
            if (!$this->config->verbose && !$this->config->quiet) {
                echo $progressBar->advance();
            }
            $begin = microtime(true);
            $analyzer = Analyzer::getInstance($analyzer_class);
            $this->configName = str_replace(array('/', '\\', 'Exakat\\Analyzer\\'), array('_', '_', ''),$analyzer_class);    
            
            if ($this->config->noRefresh === true && isset($analyzed[$analyzer_class])) {
                display( "$analyzer_class is already processed\n");
                continue 1;
            }
            $analyzer->init();
    
            if (!$analyzer->checkPhpVersion($this->config->phpversion)) {
                $analyzerQuoted = str_replace('\\', '\\\\', get_class($analyzer));
                
                $analyzer = str_replace('\\', '\\\\', $analyzer_class);
                
                $query = <<<GREMLIN
result = g.addV('Noresult').property('code',                        'Not Compatible With PhpVersion')
                           .property('fullcode',                    'Not Compatible With PhpVersion')
                           .property('virtual',                      true)
                           .property('notCompatibleWithPhpVersion', '{$this->config->phpversion}')
                           .property('token',                       'T_INCOMPATIBLE');

g.addV('Analysis').property('analyzer', '$analyzerQuoted').addE('ANALYZED').to(result);

GREMLIN;
                $this->gremlin->query($query);
                $this->datastore->addRow('analyzed', array($analyzer_class => -2 ) );

                display("$analyzer is not compatible with PHP version {$this->config->phpversion}. Ignoring\n");
            } elseif (!$analyzer->checkPhpConfiguration($Php)) {
                $analyzerQuoted = str_replace('\\', '\\\\', get_class($analyzer));
                $analyzer = str_replace('\\', '\\\\', $analyzer_class);
            
                $query = <<<GREMLIN
result = g.addV('Noresult').property('code',                              'Not Compatible With Configuration')
                           .property('fullcode',                          'Not Compatible With Configuration')
                           .property('virtual',                            true)
                           .property('notCompatibleWithPhpConfiguration', '{$this->config->phpversion}')
                           .property('token',                             'T_INCOMPATIBLE');

index = g.addV('Analysis').property('analyzer', '$analyzerQuoted').addE('ANALYZED').to(result);
GREMLIN;
                $this->gremlin->query($query);
                $this->datastore->addRow('analyzed', array($analyzer_class => -1 ) );

                display( "$analyzer is not compatible with PHP configuration of this version. Ignoring\n");
            } else {
                display( "$analyzer_class running\n");
                $analyzer->run();

                $count = $analyzer->getRowCount();
                $processed = $analyzer->getProcessedCount();
                $queries = $analyzer->getQueryCount();
                $rawQueries = $analyzer->getRawQueryCount();
                $total_results += $count;
                display( "$analyzer_class run ($count / $processed)\n");
                $end = microtime(true);
                $this->log->log("$analyzer_class\t".($end - $begin)."\t$count\t$processed\t$queries\t$rawQueries");
                // storing the number of row found in Hash table (datastore)
                $this->datastore->addRow('analyzed', array($analyzer_class => $count ) );
            }
        }

        if (!$this->config->verbose && !$this->config->quiet) {
            echo $progressBar->advance();
        }

        display( "Done\n");
    }
}

?>
