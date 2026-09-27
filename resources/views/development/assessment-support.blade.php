<div class="assessment-support-layout">
    <div class="assessment-support-main">
        @include('development.assessment-support-question', ['questionKey' => 'support', 'number' => 10])
        @include('development.assessment-support-question', ['questionKey' => 'heard', 'number' => 11])
        @include('development.assessment-support-question', ['questionKey' => 'differences', 'number' => 14])
    </div>
    <div class="assessment-support-aside">
        @include('development.assessment-support-question', ['questionKey' => 'expectations', 'number' => 12])
        @include('development.assessment-support-question', ['questionKey' => 'updates', 'number' => 13])
        <aside class="assessment-choice-help"><i class="fa-regular fa-lightbulb" aria-hidden="true"></i><div><h2>Helping You Make Informed Choices</h2><p>Your answers help us identify relevant support for your child within the VALYNK network.</p></div></aside>
    </div>
</div>
