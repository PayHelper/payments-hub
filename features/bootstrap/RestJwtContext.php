<?php

declare(strict_types=1);

use Behatch\Context\RestContext;
use Behatch\HttpCall\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

final class RestJwtContext extends RestContext
{
    private $jwtEncoder;

    public function __construct(Request $request, JWTEncoderInterface $jwtEncoder)
    {
        parent::__construct($request);

        $this->jwtEncoder = $jwtEncoder;
    }

    /**
     * @param string $username
     *
     * @Given I am authenticated as ":username"
     */
    public function iAmAuthenticatedAs(string $username)
    {
        $token = $this->jwtEncoder->encode(['username' => $username]);
        $this->request->setHttpHeader('Authorization', 'Bearer '.$token);
    }

    /**
     * @param string $username
     *
     * @Given I am want to get JSON
     */
    public function iWantToGetJson()
    {
        $this->request->setHttpHeader('Accept', 'application/json');
    }

    /**
     * @BeforeScenario
     */
    public function restoreAuthHeader()
    {
        $this->request->setHttpHeader('Authorization', null);
    }
}
