<?php

namespace Core;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class BaseController extends Response
{
    /**
     * Styling Response For Successful Responses.
     *
     * @since 1.0.0
     *
     * @param string $status
     * @param mixed $data
     * @param int $code
     *
     * @return string
     */
    public function response(string $status, $data, int $code): string
    {
    	return json_encode([
    		'status' => $status,
    		'data' => $data,
    		'code' => $code,
    	]);
    }

    /**
     * Styling Response For Unsuccessful Responses.
     *
     * @since 1.0.0
     *
     * @param string $status
     * @param mixed $data
     * @param int $code
     *
     * @return string
     */
    public function error(string $status, $data, int $code): string
    {
    	return json_encode([
    		'status' => $status,
    		'data' => $data,
    		'code' => $code,
    	]);
    }
}
