<?php
/**
 * Copyright 2014-2021 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @copyright 2014-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Core
 */
namespace Horde\Test\Stub\Registry;
/**
 * A test replacement for Horde_Registry_Loadconfig.
 *
 * @author    Michael Slusarz <slusarz@horde.org>
 * @category  Horde
 * @copyright 2014-2021 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Core
 */
class Loadconfig
{
    public $app;
    public $confFile;
    public $vars;

    public function __contruct($app, $confFile, $vars)
    {
        $this->app = $app;
        $this->confFile = $confFile;
        $this->vars = $vars;
    }
}
