<!doctype html>
<head>
    <meta charset="utf-8">

    <title>শরয়ী সমাধান</title>
    <meta name="description" content="My Parse App">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <?php
    require 'vendor/autoload.php';
    session_start();

    require './tableColumnNames.php';

    use Parse\ParseClient;
    use Parse\ParseObject;
    use Parse\ParseQuery;

if (!isset($_SESSION['qid'])) {
        echo 'session problem';
        die("<script>location.href = 'index.php'</script>");
    } else {
        $qid = $_SESSION['qid'];
    }
    ParseClient::initialize('jVbb8uYocFpOhxTnZtY8DqvVmiEVgWQyU71K24p0', 'ilsN27z74t3N7FAxGVNk7KNDZPwprFbMqWGlQQk8', 'XWMlF7HBGQgblHHN242MfBMjuZJzxH17zzkvo0SB');
    ?>
</head>

<body>
    <div class="container" style="margin-top: 200px;">
        <?php
        if(isset($_POST['goHome']))
        {
            unset($_POST['finish']);
            unset($_POST['insertComment']);
            unset($_POST['goHome']);
            unset($_SESSION['qid']);
            die("<script>location.href = 'index.php'</script>");
        }
        if (isset($_POST['insertComment']) || isset($_POST['finish'])) {
            if (isset($_POST['insertComment'])) {
                $query = new ParseQuery($TABLE_QA);
                $QA = $query->get($qid);
                $comment = $_POST['comment'];
                $commenterName = $_POST['commenterName'];
                $commenterType = $_POST['commentBy'];
                $isCommentByOlama = FALSE;
                if ($commenterType === "GU") {
                    $isCommentByOlama = FALSE;
                } else {
                    $isCommentByOlama = TRUE;
                }
                if ($isCommentByOlama) {
                    if (strlen($commenterName) >= 0 && strlen(trim($commenterName)) == 0) {
                        $commenterName = 'বিজ্ঞ ওলামা বোর্ড';
                    }
                } else {
                    if (strlen($commenterName) >= 0 && strlen(trim($commenterName)) == 0) {
                        $commenterName = 'নাম প্রকাশে অনিচ্ছুক';
                    }
                }
                $COMMENT = new ParseObject($TABLE_COMMENTS);
                $COMMENT->set($QUESTION_ID, $qid);
                $COMMENT->set($COMMENT_TEXT, $comment);
                $COMMENT->set($COMMENTER_NAME, $commenterName);
                $COMMENT->set($IS_COMMENT_BY_OLAMA, $isCommentByOlama);
                try {
                    $COMMENT->save();
                    unset($_POST['insertComment']);
                    die("<script>location.href = 'additionalComments.php'</script>");
                } catch (Parse\ParseException $exc) {
                    echo $exc->getTraceAsString() . '. Please try again';
                }
            } else {
                $query = new ParseQuery($TABLE_QA);
                $QA = $query->get($qid);
                $comment = $_POST['comment'];
                $commenterName = $_POST['commenterName'];
                $commenterType = $_POST['commentBy'];
                $isCommentByOlama = FALSE;
                if ($commenterType === "GU") {
                    $isCommentByOlama = FALSE;
                } else {
                    $isCommentByOlama = TRUE;
                }
                if ($isCommentByOlama) {
                    if (strlen($commenterName) >= 0 && strlen(trim($commenterName)) == 0) {
                        $commenterName = 'বিজ্ঞ ওলামা বোর্ড';
                    }
                } else {
                    if (strlen($commenterName) >= 0 && strlen(trim($commenterName)) == 0) {
                        $commenterName = 'নাম প্রকাশে অনিচ্ছুক';
                    }
                }
                $COMMENT = new ParseObject($TABLE_COMMENTS);
                $COMMENT->set($QUESTION_ID, $qid);
                $COMMENT->set($COMMENT_TEXT, $comment);
                $COMMENT->set($COMMENTER_NAME, $commenterName);
                $COMMENT->set($IS_COMMENT_BY_OLAMA, $isCommentByOlama);
                try {
                    $COMMENT->save();
                    unset($_POST['finish']);
                    unset($_SESSION['qid']);
                    die("<script>location.href = 'index.php'</script>");
                } catch (Parse\ParseException $exc) {
                    echo $exc->getTraceAsString() . '. Please try again';
                }
                
            }
        } else {
            $query = new ParseQuery($TABLE_QA);
            $QA = $query->get($qid);
            $question = $QA->get($QUESTION);
            $answer = $QA->get($ANSWER);
            $questionBy = $QA->get($ASKER_NAME);
            $answeredBy = $QA->get($ANSWERED_BY);
            
            $cQuery = new ParseQuery($TABLE_COMMENTS);
            $cQuery->equalTo($QUESTION_ID, $qid);
            $cResult = $cQuery->find();
        }
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Additional data</h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td>
                                <h4>প্রশ্ন</h4>
                                <br>
                                <p><?php echo '' . $question; ?></p>
                                <div style="float: right;">
                                    <p><strong>-<?php echo '' . $questionBy; ?></strong></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4>উত্তর</h4>
                                <br>
                                <p><?php echo '' . $answer; ?></p>
                                 <div style="float: right;">
                                     <p><strong>-<?php echo '' . $answeredBy; ?></strong></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered">
                    <thead>
                        <tr class="danger">
                            <td>
                                <strong>Comments</strong>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(count($cResult) === 0)
                            {
                                ?>
                        <tr>
                            <td>No comments</td>
                        </tr>
                                <?php
                            }  else {
                                foreach ($cResult as $c)
                                {
                                    $cText = $c->get($COMMENT_TEXT);
                                    $cName = $c->get($COMMENTER_NAME);
                                    $cIsByOlama = $c->get($IS_COMMENT_BY_OLAMA);
                                    if($cIsByOlama){
                                        echo '<tr class="active">';
                                    }  else {
                                        echo '<tr class="info">';
                                    }
                                    ?>    
                                        <td>
                                            <p><?php echo '' . $cText; ?></p>
                                             <div style="float: right;">
                                                 <p><strong>-<?php echo '' . $cName; ?></strong></p>
                                            </div>
                                        </td>
                                    </tr>    
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
                <form action="additionalComments.php" method="post">

                    <div class="form-group">
                        <label>Additional comments</label>
                        <input  class="form-control" type="text"  name="comment" placeholder="দেয়া জরুরি। " required>
                    </div>

                    <div class="form-group">
                        <label>Commenter's Name</label>
                        <input  class="form-control" type="text"  name="commenterName" placeholder="দেয়া জরুরি না। ">
                    </div>

                    <div class="form-group">
                        <label>Comment by</label>
                        <select name="commentBy" class="form-control">
                            <option value="GU">General user</option>
                            <option value="OB">Olama board</option>
                        </select>
                    </div>
                    <div class="panel-footer">
                        <button  name="insertComment" type="submit" class="btn btn-lg btn-success" style="float: right">Add this comment and add more</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-footer">
                        <button  name="finish" type="submit" class="btn btn-lg btn-success" style="float: right">Add this comment and go home ending inserting comments for this</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
                <form action="additionalComments.php" method="post">
                    <div class="panel-footer">
                        <button  name="goHome" type="submit" class="btn btn-lg btn-success" style="float: right">Go home without adding any comment</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
</body>

</html>
