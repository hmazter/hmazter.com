<?php

function calculateBaseUrlFromEnvironment()
{
    if (getenv('CONTEXT') === 'deploy-preview' && getenv('DEPLOY_PRIME_URL') !== false) {
        return getenv('DEPLOY_PRIME_URL');
    }
    if (getenv('URL') !== false) {
        return getenv('URL');
    }
    return 'https://www.hmazter.com';
}

return [
    'baseUrl' => calculateBaseUrlFromEnvironment(),
    'production' => true,
];
