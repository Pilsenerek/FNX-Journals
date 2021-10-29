<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Article;
use App\Model\Chat;
use App\Model\User;
use App\RepositoryAbstract;
use stdClass;

/**
 * @author Michal Zbieranek
 */
class ChatRepository extends RepositoryAbstract {

    /**
     * @return array
     */
    public function getUnreadMessages(): array {
        $query = $this->pdo->prepare(
                "select * from chat where is_read=0 order by id"
        );
        $query->execute();
        //$query2 = $this->pdo->prepare("UPDATE chat SET is_read=1 WHERE is_read=0");
        //$query2->execute();

        $records = [];
        while ($stdClass = $query->fetchObject()) {
            $records[] = $this->createChatModel($stdClass);
        }

        return $records;
    }

    /**
     * @param string $message
     * @param User $user
     * @return bool
     */
    public function addMessage(string $message, User $user): bool {
        $query = $this->pdo->prepare("insert into chat (username, message) values(?,?)");
        if ($query->execute([$user->getUsername(), $message])) {

            return true;
        }

        return false;
    }

    /**
     * @param stdClass $stdClass
     * @return Chat
     */
    private function createChatModel(stdClass $stdClass): Chat {
        $chat = new Chat();
        $chat->setId((int) $stdClass->id);
        $chat->setUsername($stdClass->username);
        $chat->setMessage($stdClass->message);
        $chat->setTime(new \DateTime($stdClass->time));
        $chat->setIsRead((bool)$stdClass->is_read);

        return $chat;
    }

}
