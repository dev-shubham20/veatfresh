<?php
 
if ( ! function_exists('render_frontend'))
{
    function render_frontend(string $name, array $data = [], array $options = [])
    {
        return view(
            'includes/layout',
            [
                'content' => view($name, $data, $options),
            ],
            $options
        );
    }
}

if ( ! function_exists('render_backend'))
{
    function render_backend(string $name, array $data = [], array $options = [])
    {
        return view(
            'back/includes/layout',
            [
                'content' => view($name, $data, $options),
            ],
            $options
        );
    }
}