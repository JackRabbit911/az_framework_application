<?php

return [
    'status' => 'success',
    'title' => 'Restore password',
    'appeal' => "Dear, {$user->name}!",
    'text' => url('restore', ['action' => 'confirm', 'code' => $this->session->code]),
    'msg' => 'A message with a link to restore password has been sent to the email address you provided.',
];
