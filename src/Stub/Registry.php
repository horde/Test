<?php
/**
 * Copyright 2011-2021 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Horde
 * @package  Test
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
namespace Horde\Test\Stub;
use Horde\Exception\HordeException;
use Horde\Test\Stub\Registry\Loadconfig;
/**
 * A test replacement for Horde_Registry.
 *
 * @category Horde
 * @package  Test
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL
 * @link     http://www.horde.org/components/Horde_Test
 */
class Registry
{
    /**
     * A flag that is set once the basic horde application has been
     * minimally configured.
     *
     * @var bool
     */
    public bool $hordeInit = false;

    /**
     * The currrent user.
     *
     * @var string
     */
    protected string $user;

    /**
     * The current application.
     *
     * @var string
     */
    protected string $app;

    /**
     * List of pre-configured configuration objects.
     *
     * @var array
     */
    protected array $configObjects = [];

    /**
     * Constructor.
     *
     * @param string $user The current user.
     * @param string $app  The current application.
     */
    public function __construct(string $user, string $app)
    {
        $this->user = $user;
        $this->app = $app;
    }

    /**
     * Converts an authentication username to a unique Horde username.
     *
     * @param string $userId    The username to convert.
     * @param bool   $toHorde  If true, convert to a Horde username. If
     *                          false, convert to the auth username.
     *
     * @return string  The converted username.
     * @throws HordeException
     */
    public function convertUsername($userId, $toHorde)
    {
        return $userId;
    }

    /**
     * Returns the currently logged in user, if there is one.
     *
     * @param string $format  The return format, defaults to the unique Horde
     *                        ID. Alternative formats:
     * <pre>
     * bare - Horde ID without any domain information.
     *        EXAMPLE: foo@example.com would be returned as 'foo'.
     * domain: Domain of the Horde ID.
     *         EXAMPLE: foo@example.com would be returned as 'example.com'.
     * original: The username used to originally login to Horde.
     * </pre>
     *
     * @return mixed  The user ID or false if no user is logged in.
     */
    public function getAuth($format = null)
    {
        return $this->user;
    }

    /**
     * Is a user an administrator?
     *
     * @param array $options  Options:
     * <pre>
     * 'permission' - (string) Allow users with this permission admin access
     *                in the current context.
     * 'permlevel' - (integer) The level of permissions to check for.
     *               Defaults to Horde_Perms::EDIT.
     * 'user' - (string) The user to check.
     *          Defaults to self::getAuth().
     * </pre>
     *
     * @return bool  Whether or not this is an admin user.
     */
    public function isAdmin(array $options = []): bool
    {
        return false;
    }

    /**
     * Returns information about the remote host.
     *
     * @return object  An object with the following properties:
     * <pre>
     *   - addr: (string) Remote IP address.
     *   - host: (string) Remote hostname (if resolvable; otherwise, this value
     *           is identical to 'addr').
     *   - proxy: (boolean) True if this user is connecting through a proxy.
     * </pre>
     */
    public function remoteHost(): object
    {
        return (object)[
            'addr' => '1.2.3.4',
            'host' => 'example.com',
            'proxy' => false
        ];
    }

    /**
     * Assigns a (pre-configured) Loadconfig object.
     *
     * This object will be returned by loadConfig(), if the same parameters are
     * used.
     *
     * @since Horde_Test 2.6.0
     *
     * @param object $loadconfig Configuration object.
     * @param string $conf_file  Configuration file name.
     * @param mixed $vars        List of config variables to load.
     * @param string $app        Application.
     */
    public function setConfigFile(
        $loadconfig, $conf_file, $vars = null, $app = null
    )
    {
        $sig = serialize(array($conf_file, $vars, $app));
        $this->configObjects[$sig] = $loadconfig;
    }

    /**
     * Load a configuration file from a Horde application's config directory.
     * This call is cached (a config file is only loaded once, regardless of
     * the $vars value).
     *
     * @param string $conf_file  Configuration file name.
     * @param mixed $vars        List of config variables to load.
     * @param string $app        Application.
     *
     * @return Loadconfig  The config object.
     * @throws HordeException
     */
    public function loadConfigFile($conf_file, $vars = null, $app = null)
    {
        if ($conf_file == 'hooks.php') {
            throw new HordeException('Failed to import configuration file "hooks.php".');
        }

        $sig = serialize(array($conf_file, $vars, $app));
        if (isset($this->configObjects[$sig])) {
            return $this->configObjects[$sig];
        }

        return new Loadconfig(
                $app,
                $conf_file,
                $vars
        );
    }

    /**
     * Return the requested configuration parameter for the specified
     * application. If no application is specified, the value of
     * the current application is used. However, if the parameter is not
     * present for that application, the Horde-wide value is used instead.
     * If that is not present, we return null.
     *
     * @param string $parameter  The configuration value to retrieve.
     * @param string $app        The application to get the value for.
     *
     * @return string  The requested parameter, or null if it is not set.
     */
    public function get($parameter, $app = null): ?string
    {
        return '';
    }

    /**
     * Return the current application - the app at the top of the application
     * stack.
     *
     * @return string  The current application.
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Determine if an interface is implemented by an active application.
     *
     * @param string $interface  The interface to check for.
     *
     * @return mixed  The application implementing $interface if we have it,
     *                false if the interface is not implemented.
     */
    public function hasInterface(string $interface)
    {
        return false;
    }

    /**
     * Returns all available registry APIs.
     *
     * @return array  The API list.
     */
    public function listAPIs()
    {
        return [];
    }
}
