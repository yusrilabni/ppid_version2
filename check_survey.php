<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$q = App\Models\SurveyQuestion::where('question', 'LIKE', '%Jika terjadi kesalahan input%')->first();
if($q){
    echo "Question ID: " . $q->id . " Type: " . $q->type . "\n";
    $opts = App\Models\SurveyOption::where('survey_question_id', $q->id)->get();
    foreach($opts as $o) {
        echo "Option ID: " . $o->id . " - " . $o->option_text . " (Val: " . $o->value . ")\n";
    }
    $answers = App\Models\SurveyAnswer::where('survey_question_id', $q->id)->get();
    echo "Sample answers:\n";
    foreach($answers->take(5) as $ans) {
        echo "Response ID: " . $ans->survey_response_id . " Answer: " . $ans->answer_text . "\n";
    }
} else {
    echo "Question not found\n";
}
