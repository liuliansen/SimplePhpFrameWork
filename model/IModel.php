<?php
namespace model;

interface IModel {
    /**
     * 获取记录
     * @param array $args
     */
    public function get($args = array());

    /**
     * @param array $args
     * @return mixed
     */
    public function add($args = array());
}