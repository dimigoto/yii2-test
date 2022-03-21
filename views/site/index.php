<?php

use app\models\search\HistorySearch;
use app\widgets\HistoryList\HistoryList;

/** @var $title string */
/** @var $model HistorySearch */

$this->title = 'Americor Test';
?>

<div class="site-index">
    <?= HistoryList::widget(
        [
            'model' => $model
        ]
    ) ?>
</div>
