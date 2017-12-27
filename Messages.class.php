<?php

class Messages {
  public $db;

  function __construct() {
    $this->db = require './db.inc.php';
  }

  public function all() {
    require_once './Helper.class.php';
    Helper::session_start();
    $q_get_all_messages = $this->db->prepare("
      SELECT `messages`.*, `users`.`username`
      FROM `messages`, `users`
      WHERE `to_id` = :to_id
      AND `messages`.`from_id` = `users`.`id`
    ");

    $q_get_all_messages->execute([
      ':to_id' => Helper::get_id()
    ]);

    return $q_get_all_messages->fetchAll();
  }

  public function delete($id) {
    $q_delete_msg = $this->db->prepare("
      DELETE
      FROM `messages`
      WHERE `id` = :id
    ");
    $q_delete_msg->execute([
      ':id' => $id
    ]);
  }

  public function add($to, $subject, $message) {
    $q_add_msg = $this->db->prepare("
      INSERT INTO `messages`
      (
        `from_id`, `to_id`, `subject`, `message`
      )
      VALUES (
        :from_id, :to_id, :subject, :message
      )
    ");

    require_once './Helper.class.php';
    require_once './User.class.php';
    $u = new User();
    $user_info = $u->info_by_username($to);

    if (!$user_info) {
      return false;
    }

    return $q_add_msg->execute([
      ':from_id' => Helper::get_id(),
      ':to_id' => $user_info['id'],
      ':subject' => $subject,
      ':message' => $message
    ]);
  }

  public function one($id) {
    require_once './Helper.class.php';
    Helper::session_start();
    $q_get_message = $this->db->prepare("
      SELECT `messages`.*, `users`.`username`
      FROM `messages`, `users`
      WHERE `messages`.`id` = :id
      AND `messages`.`from_id` = `users`.`id`
      AND (
        `to_id` = :to_id
        OR `from_id` = :to_id
        )
    ");

    $q_get_message->execute([
      ':to_id' => Helper::get_id(),
      ':id' => $id
    ]);

    $msg = $q_get_message->fetch();

    if ($msg && is_null($msg['date_read']) && $msg['to_id'] == Helper::get_id()) {
      $q_mark_as_read = $this->db->prepare("
        UPDATE `messages`
        SET `date_read` = CURRENT_TIMESTAMP()
        WHERE `id` = :msg_id
      ");
      $q_mark_as_read->execute([
        ':msg_id' => $msg['id']
      ]);
    }
    return $msg;
  }

  public function num_of_unread() {
    require_once './Helper.class.php';
    $q_get_unread_msg_count = $this->db->prepare("
      SELECT *
      FROM `messages`
      WHERE `to_id` = :to_id
      AND `date_read` IS NULL
    ");
    $q_get_unread_msg_count->execute([
      ':to_id' => Helper::get_id()
    ]);
    return $q_get_unread_msg_count->rowCount();
  }

  public function sent_messages() {
    require_once './Helper.class.php';
    $q_get_sent_messages = $this->db->prepare("
      SELECT `messages`.*, `users`.`username`
      FROM `messages`, `users`
      WHERE `from_id` = :from_id
      AND `messages`.`to_id` = `users`.`id`
    ");
    $q_get_sent_messages->execute([
      ':from_id' => Helper::get_id()
    ]);
    return $q_get_sent_messages->fetchAll();
  }
}
