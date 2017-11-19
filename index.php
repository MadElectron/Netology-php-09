<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Новости</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php

    class News
    {
        private static $currentId = 0;

        private $id;
        private $title;
        private $content;
        private $source;
        private $date;
        private $comments =[];

        public function __construct($title, $content, $source, $date = null)
        {
            $this->id = ++self::$currentId; // Autoincrement id
            $this->title = $title;
            $this->content = $content;
            $this->source = $source;
            $this->date = $date or new DateTime();
        }


        public function getId()
        {
            return $this->id;
        }

        public function getTitle()
        {
            return $this->title;
        }

        public function getContent()
        {
            return $this->content;
        }

        public function getSource()
        {
            return $this->source;
        }

        public function getDate()
        {
            return $this->date;
        }

        public function getComments($json)
        {
            $data = json_decode($json, true);
            $comments = [];

            foreach ($data as $d) {
                if ($d['newsId'] == $this->id) {
                    $comments[] = new Comment($d['username'], $d['content']);
                }
            }

            return $comments;
        }


        public function setTitle($title)
        {
            $this->title = $title;
        }

        public function setContent($content)
        {
            $this->content = $content;
        }

        public function setSource($source)
        {
            $this->source = $source;
        }

        public function setDate($date)
        {
            $this->date = $date;
        }
    }

    class Comment {
        private $username;
        private $content;
        private $date;

        public function __construct($username, $content) {
            $this->username = $username;
            $this->content = $content;
            $this->date = new DateTime();
        }

        public function getUsername()
        {
            return $this->username;
        }

        public function getContent()
        {
            return $this->content;
        }

        public function getDate()
        {
            return $this->date;
        }
    }

    $json = file_get_contents('json/news.json');
    $data = json_decode($json, true);
    $news = [];

    foreach ($data as $d) {
        $date = new DateTime(isset($d['date']) ? $d['date'] : 'now');
        $news[] = new News($d['title'], $d['content'], $d['source'], $date);
    }

    $commentJson = file_get_contents('json/comments.json');
?>
    <div class="container">
        <h1>Новости</h1>
        <? foreach($news as $article) { 
            $source = $article->getSource();
            $comments = $article->getComments($commentJson);
        ?>
        <article class="news-article">
            <h2 class="news-title"><? echo $article->getId().'. '.$article->getTitle(); ?></h2>    
            <p class="news-date"><? echo $article->getDate()->format("Y-m-d H:i") ?></p>
            <hr>
            <p class="news-content"><? echo $article->getContent() ?></p>
            <p class="news-source">Источник: 
                <a href="<? echo $source ?>" target="_blank"><? echo $source ?></a>
            </p>
            <hr>
            <div class="news-comment-box">
                <p class="news-comment-line">Комментарии[<? echo count($comments); ?>]</p>  

                <? foreach ($comments as $comment) { ?>
                    <p class="news-comment-username"><? echo $comment->getUsername(); ?> написал(а):</p>
                    <p class="news-comment"><? echo $comment->getContent(); ?></p>
                <? } ?>
            </div>
        </article>
        <? } ?>
    </div>
</body>
</html>