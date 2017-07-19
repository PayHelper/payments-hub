<?php

declare(strict_types=1);

use Behatch\Context\RestContext;

final class RestJwtContext extends RestContext
{
    private $jwtEncoder;

    public function __construct(\Behatch\HttpCall\Request $request, \Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface $jwtEncoder)
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
     * @BeforeScenario
     */
    public function restoreAuthHeader()
    {
        $this->request->setHttpHeader('Authorization', null);
    }
}
