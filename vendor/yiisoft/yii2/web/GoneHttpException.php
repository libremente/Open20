<?php
/**
 */

namespace yii\web;

/**
 * GoneHttpException represents a "Gone" HTTP exception with status code 410.
 *
 * Throw a GoneHttpException when a user requests a resource that no longer exists
 * at the requested url. For example, after a record is deleted, future requests
 * for that record should return a 410 GoneHttpException instead of a 404
 * [[NotFoundHttpException]].
 *
 * @since 2.0
 */
class GoneHttpException extends HttpException
{
    /**
     * Constructor.
     * @param string $message error message
     * @param int $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(410, $message, $code, $previous);
    }
}