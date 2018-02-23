<?php


/*class AppError {
    public static function handleError($code, $description, $file = null,
        $line = null, $context = null) {
        list(, $level) = ErrorHandler::mapErrorCode($code);
        if ($level === LOG_ERR) {

        	header("Location: http://107.170.152.166/twop/");
            // Ignore fatal error. It will keep the PHP error message only
            return false;
        }
        return ErrorHandler::handleError(
            $code,
            $description,
            $file,
            $line,
            $context
        );
    }
}*/

class AppError {

    public static function handleError($code, $description, $file = null,
    	
        $line = null, $context = null) {
        echo 'There has been an error!';
    }
}
?>