<?php 
function getLatestCommit() {
    return substr(file_get_contents(sprintf( '.git/refs/heads/%s', 'dev' )),0,8);
}

echo "<div class='h-100 d-flex align-items-center justify-content-center flex-column'>
<p class='font-weight-light'><small>(C) " . date('Y') . " Marco Pisco - <a href='https://github.com/marpisco/formfill/commit/" . getLatestCommit() ."'>Version " . getLatestCommit() . "</a> in branch <i>dev</i></small></p></div>
</div>" ?>