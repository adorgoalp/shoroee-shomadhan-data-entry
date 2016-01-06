<?php
ob_start();
?>
<html>
    <head>
        <meta charset="utf-8">

        <title>শরয়ী সমাধান</title>
        <meta name="description" content="My Parse App">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/iftaCss.css">
        <?php
        require 'vendor/autoload.php';
        session_start();

        require './tableColumnNames.php';
        use Parse\ParseClient;
        use Parse\ParseObject;
ParseClient::initialize('jVbb8uYocFpOhxTnZtY8DqvVmiEVgWQyU71K24p0', 'ilsN27z74t3N7FAxGVNk7KNDZPwprFbMqWGlQQk8', 'XWMlF7HBGQgblHHN242MfBMjuZJzxH17zzkvo0SB');
        ?>
    </head>

    <body>
        <?php
        if (isset($_POST['insertData'])) {
            $question = $_POST['question'];
            $answer = $_POST['answer'];
            $QA = new ParseObject("QuestionAnswer");
            $QA->set($QUESTION, $question);
            $QA->set($ANSWER, $answer);
            $QA->set($IS_ANSWERED, TRUE);
            try {
                $QA->save();
                $_SESSION['qid'] = $QA->getObjectId();
                //echo 'qid '.$_SESSION['qid'];
                die("<script>location.href = 'addNameInfo.php'</script>");
            } catch (Parse\ParseException $exc) {
                echo $exc->getTraceAsString() . '. Please try again';
            }
        }
        ?>
        <div class="container" style="margin-top: 200px;">
            <form action="index.php" method="post">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Data entry form for Kajol vai and his team</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label>Question</label>
                            <textarea  class="form-control" placeholder="দিতেই হবে। নাহলে হবে না।" name="question" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Answer</label>
                            <textarea  class="form-control" placeholder="দিতেই হবে। নাহলে হবে না।" name="answer" rows="10" required></textarea>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <button  name="insertData" type="submit" class="btn btn-lg btn-success" style="float: right" >Next</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
            <div>
                <h3>Log into <a href="https://www.parse.com/" target="_blank">Parse</a> and go to following links to </h3>
                <ol>
                    <li><a href="https://www.parse.com/apps/shoroee-shomadhan/collections#class/QuestionAnswer">View Question Answer Data</a></li>
                    <li><a href="https://www.parse.com/apps/shoroee-shomadhan/collections#class/Comments">View Comment data</a></li>
                    <li><a href="https://www.parse.com/apps/shoroee-shomadhan/collections#class/Category">View Category data</a></li>
                </ol>
            </div>
        </div>
    </body>
    <footer>
        <div style="margin: 100px;"></div>
    </footer>
</html>
