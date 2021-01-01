<?php

namespace App\Model;

use Nette;
use Nette\Security;
use Nette\Security\IIdentity;
use Nette\Utils\DateTime;


class Authenticator implements Security\IAuthenticator
{
    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    /**
     * Performs an authentication.
     * @return Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials): IIdentity
    {
        list($email, $password) = $credentials;
        $row = $this->database->table('user')->where('email', $email)->fetch();

        $security = new Security\Passwords();
        if (!$row || !$security->verify($password, $row->password))
            throw new Security\AuthenticationException('Nebylo vyplněno správné heslo.', self::INVALID_CREDENTIAL);

        $this->database
            ->table('user')
            ->wherePrimary($row->id)
            ->update([
                'ip' => $_SERVER["REMOTE_ADDR"],
                'date_log' => new DateTime(),
            ]);
        return new Security\Identity($row->id, $row->role, $row);
    }

}