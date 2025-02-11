<?php

namespace AsyncAws\Athena\Exception;

use AsyncAws\Core\Exception\Http\ClientException;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * An exception that Athena received when it called a custom metastore. Occurs if the error is not caused by user input
 * (`InvalidRequestException`) or from the Athena platform (`InternalServerException`). For example, if a user-created
 * Lambda function is missing permissions, the Lambda `4XX` exception is returned in a `MetadataException`.
 */
final class MetadataException extends ClientException
{
    protected function populateResult(ResponseInterface $response): void
    {
        $data = $response->toArray(false);

        if (null !== $v = (isset($data['message']) ? (string) $data['message'] : null)) {
            $this->message = $v;
        }
    }
}
