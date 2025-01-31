<?php
  print(substr(file_get_contents(sprintf( '.git/refs/heads/%s', 'dev' )),0,8));
?>