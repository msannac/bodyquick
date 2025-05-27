@php
    $faqs = config('faq');
@endphp
<div class="container mt-4 mb-4" style="background: #f8f9fa; border-radius: 1rem; box-shadow: 0 2px 16px rgba(0,0,0,0.06);">
    <h1 class="mb-4 text-center"><i class="fas fa-question-circle text-success"></i> Preguntas Frecuentes</h1>
    <div class="accordion shadow-sm rounded-lg" id="faqAccordion">
        @foreach($faqs as $i => $faq)
            <div class="card mb-2 border-0 rounded-lg">
                <div class="card-header bg-light border-0 @if($i === 0) rounded-top @elseif($i === count($faqs)-1) rounded-bottom @endif" id="faq{{ $i+1 }}">
                    <h2 class="mb-0">
                        <button class="btn btn-link text-dark font-weight-bold @if($i !== 0) collapsed @endif" type="button" data-toggle="collapse" data-target="#collapse{{ $i+1 }}" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $i+1 }}">
                            {!! $faq['question'] !!}
                        </button>
                    </h2>
                </div>
                <div id="collapse{{ $i+1 }}" class="collapse @if($i === 0) show @endif" aria-labelledby="faq{{ $i+1 }}" data-parent="#faqAccordion">
                    <div class="card-body bg-white">
                        {!! $faq['answer'] !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
