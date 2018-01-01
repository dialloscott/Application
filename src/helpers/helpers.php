<?php
function _yield(string $string, array $params = []):string
{
    extract($params);
    return $string;
}