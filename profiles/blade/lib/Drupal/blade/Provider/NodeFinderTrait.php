<?php

namespace Drupal\blade\Provider;

trait NodeFinderTrait
{
    /**
     * Find if post was already imported
     *
     * @param  string                 $postId a remote post Id
     * @return mixed(false|\stdClass) a node entity or false
     */
    private function findByRemoteId($id)
    {
        $query = new \EntityFieldQuery();
        $query
            ->entityCondition('entity_type', 'node')
            ->entityCondition('bundle', 'news')
            ->fieldCondition('field_remote_id', 'value', $id, '=')
            ->range(0, 1);
        $result = $query->execute();

        if (isset($result['node'])) {
            return entity_load('node', array_keys($result['node']));
        }

        return false;
    }
}
