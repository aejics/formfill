<?php 
function getLatestCommit() {
    return substr(file_get_contents(sprintf( '.git/refs/heads/%s', 'dev' )),0,8);
}

echo "<hr><div class='h-100 d-flex align-items-center justify-content-center flex-column'>
<p class='font-weight-light'><small>(C) " . date('Y') . " AEJICS (coded by Marco Pisco) - <a href='https://github.com/marpisco/formfill/commit/" . getLatestCommit() ."'>Versão " . getLatestCommit() . "</a></i></small></p>" ?>