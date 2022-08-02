<?php
namespace RealEstate\Core\User\Interfaces;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface PasswordEncryptorInterface
{
    /**
     * @param string $password
     * @return string
     */
    public function encrypt($password);

    /**
     *
     * @param string $password
     * @param string $hash
     * @return string
     */
    public function verify($password, $hash);
}