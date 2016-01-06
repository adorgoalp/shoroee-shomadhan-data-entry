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
        if (isset($_POST['insertNameData'])) {
            $query = new ParseQuery("QuestionAnswer");
            $QA = $query->get($qid);
            $askerName = $_POST['askerName'];
            $answeredBy = $_POST['answeredBy'];
            $category = $_POST['category'];
            if (strlen($askerName) >= 0 && strlen(trim($askerName)) == 0) {
                $askerName = 'নাম প্রকাশে অনিচ্ছুক';
            }
            if (strlen($answeredBy) >= 0 && strlen(trim($answeredBy)) == 0) {
                $answeredBy = 'বিজ্ঞ ওলামা বোর্ড';
            }
            if (strlen($category) >= 0 && strlen(trim($category)) == 0) {
                $category = 'None';
            }else{
                $catQuery = new ParseQuery($TABLE_CATEGORY);
                $catQuery->equalTo($CATEGORY, $category);
                $catResult = $catQuery->find();
                if(count($catResult) === 0)
                {
                    $catobj = new ParseObject($TABLE_CATEGORY);
                    $catobj->set($CATEGORY, $category);
                    $catobj->save();
                }
            }
            

            $QA->set($ASKER_NAME, $askerName);
            $QA->set($ANSWERED_BY, $answeredBy);
            $QA->set($CATEGORY, $category);
            try {
                $QA->save();
                die("<script>location.href = 'additionalComments.php'</script>");
            } catch (Parse\ParseException $exc) {
                echo $exc->getTraceAsString() . '. Please try again';
            }
        } else {
            $query = new ParseQuery("QuestionAnswer");
            $QA = $query->get($qid);
            $question = $QA->get($QUESTION);
            $answer = $QA->get($ANSWER);
        }
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Additional data</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>
                                <h2>প্রশ্ন</h2>
                                <br>
                                <p><?php echo '' . $question; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h2>উত্তর</h2>
                                <br>
                                <p><?php echo '' . $answer; ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <form action="addNameInfo.php" method="post">
                    <div class="form-group">
                        <label>প্রশ্ন করেছেন</label>
                        <input  class="form-control" type="text"  name="askerName" placeholder="দেয়া জরুরি না। ফাকা রাখতে চাইলে রাখতে পারেন। এক্ষেত্রে নাম দেয়া হবে 'নাম প্রকাশে অনিচ্ছুক'। ">
                    </div>
                    <div class="form-group">
                        <label>উত্তর দিয়েছেন</label>
                        <input class="form-control" type="text" name="answeredBy" placeholder="দেয়া জরুরি না। ফাকা রাখতে চাইলে রাখতে পারেন। এক্ষেত্রে নাম দেয়া হবে 'বিজ্ঞ ওলামা বোর্ড'। ">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <input class="form-control" type="text" name="category" placeholder="দেয়া জরুরি না। ফাকা রাখতে চাইলে রাখতে পারেন। এখনি দিলে ভালো হয়।">
                    </div>
                    <div class="panel-footer">
                        <button  name="insertNameData" type="submit" class="btn btn-lg btn-success" style="float: right">Next</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
</body>

</html>
