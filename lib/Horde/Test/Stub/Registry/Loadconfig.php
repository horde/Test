<?php
/**
 * Copyright 2014-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @copyright 2014-2017 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Core
 */

/**
 * A test replacement for Horde_Registry_Loadconfig.
 *
 * @author    Michael Slusarz <slusarz@horde.org>
 * @category  Horde
 * @copyright 2014-2017 Horde LLC
 * @license   http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @package   Core
 */
class Horde_Test_Stub_Registry_Loadconfig
{
    public $app;
    public $conf_files;
    public $vars;

    public function __construct($app, $conf_file, $vars)
    {
        $this->app = $app;
        $this->conf_file = $conf_file;
        $this->vars = $vars;
    }
}
