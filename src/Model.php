<?php

namespace Topic;

class Model
{

    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $sql = 'SELECT id
                FROM topic
                WHERE status = :status
                ORDER BY id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':status', self::STATUS_ENABLED, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTopic($id)
    {
        $sql = 'SELECT *
                FROM topic
                WHERE id = :id
                AND status = :status
                LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->bindValue(':status', self::STATUS_ENABLED, \PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if ($res) {
            return $res[0];
        }
        return array();
    }

    public function getRandomTopic()
    {
        $sql = 'SELECT * FROM topic WHERE status = :status ORDER BY RANDOM() LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':status', self::STATUS_ENABLED, \PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if ($res) {
            return $res[0];
        }
        return array();
    }

    public function addTopic($title, $tags, $status = self::STATUS_DISABLED)
    {
        $sql = 'INSERT INTO topic (title, tags, status) VALUES (:title, :tags, :status);';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':title', $title, \PDO::PARAM_STR);
        $stmt->bindValue(':tags', $tags, \PDO::PARAM_STR);
        $stmt->bindValue(':status', $status, \PDO::PARAM_INT);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }
}
