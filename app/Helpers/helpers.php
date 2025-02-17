<?php

if (!function_exists('generateProductCode')) {
    function generateProductCode()
    {
        return 'PRD-' . strtoupper(uniqid());
    }
}