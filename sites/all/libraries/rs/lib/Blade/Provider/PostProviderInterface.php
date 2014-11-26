<?php

namespace Blade\Provide;

interface PostProviderInterface
{
    /**
     * this method fetch Posts from remote resources
     * @return array returns an array of Blade\Post instances
     */
    public function fetch();
}
