<?php

namespace Topic;

class Model
{

    private $c;

    public function __construct($c)
    {
        $this->c = $c;
    }

    public function loadTopic($id)
    {
        $sql = 'SELECT *
                FROM topic
                WHERE id = :id
                LIMIT 1';
        $stmt = $this->c->database->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if ($res) {
            return $res[0];
        }
        return array();
    }

    public function loadRandomTopic()
    {
        $sql = 'SELECT * FROM topic ORDER BY RANDOM() LIMIT 1';
        $stmt = $this->c->database->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if ($res) {
            return $res[0];
        }
        return array();
    }
}
