<?php

declare(strict_types=1);

use Behatch\Context\RestContext;

final class RestJwtContext extends RestContext
{
    /**
     * @param string $username
     * @param string $password
     *
     * @Given I am authenticated as ":username" with ":password" password
     */
    public function iAmAuthenticatedAs(string $username, string $password)
    {
        $this->request->setHttpHeader('Authorization', null);
        $this->request->send(
            'POST',
            '/api/v1/login_check',
            [],
            [],
            json_encode([
                'username' => $username,
                'password' => $password,
            ])
        );

        $actual = $this->request->getContent();
        $response = json_decode($actual, true);
        $this->request->setHttpHeader('Authorization', 'Bearer '.$response['token']);
    }

    /**
     * Removes a header identified by $headerName
     *
     * @param string $headerName
     */
    protected function removeHeader($headerName)
    {
        if (array_key_exists($headerName, $this->request->getHttpHeaders())) {
            unset($this->request->getHttpHeaders()[$headerName]);
        }
    }
}
