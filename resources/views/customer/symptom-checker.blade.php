@extends('customer.layout.app')

@section('title', 'Symptom Checker')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <div class="rounded-circle bg-light-purple p-3 d-inline-flex mb-3">
                    <i class="fas fa-stethoscope fa-2x text-purple"></i>
                </div>
                <h1 class="display-5 fw-bold text-gradient mb-3">Symptom Checker</h1>
                <p class="lead text-secondary mx-auto" style="max-width: 700px;">
                    Enter your symptoms and we'll suggest possible medications to help you feel better
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light-gradient border-0 rounded-top">
                            <h4 class="text-purple mb-0">Find Medications Based on Your Symptoms</h4>
                            <p class="text-muted mb-0 small">
                                This tool provides suggestions only and is not a substitute for professional medical advice.
                            </p>
                        </div>
                        <div class="card-body p-4">
                            <div id="symptomCheckerSteps">
                                <!-- Step 1: Select Symptoms -->
                                <div class="step" id="step1">
                                    <h5 class="text-purple mb-3">Step 1: Select Your Symptoms</h5>
                                    <div class="row row-cols-1 row-cols-md-3 g-3 mb-4">
                                        @foreach($commonSymptoms as $index => $symptom)
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input symptom-checkbox" type="checkbox" value="{{ $symptom }}" id="symptom{{ $index }}">
                                                <label class="form-check-label" for="symptom{{ $index }}">{{ $symptom }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <h5 class="text-purple mb-3">How long have you had these symptoms?</h5>
                                    <div class="mb-4">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input duration-radio" type="radio" name="duration" id="duration1" value="less-than-day">
                                            <label class="form-check-label" for="duration1">Less than a day</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input duration-radio" type="radio" name="duration" id="duration2" value="1-3-days">
                                            <label class="form-check-label" for="duration2">1-3 days</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input duration-radio" type="radio" name="duration" id="duration3" value="4-7-days">
                                            <label class="form-check-label" for="duration3">4-7 days</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input duration-radio" type="radio" name="duration" id="duration4" value="more-than-week">
                                            <label class="form-check-label" for="duration4">More than a week</label>
                                        </div>
                                    </div>
                                    
                                    <div class="text-end">
                                        <button type="button" class="btn btn-purple" id="goToStep2" disabled>
                                            Next <i class="fas fa-arrow-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Step 2: Additional Information -->
                                <div class="step d-none" id="step2">
                                    <h5 class="text-purple mb-3">Step 2: Additional Information</h5>
                                    <div class="mb-4">
                                        <textarea class="form-control" id="additionalInfo" rows="4" placeholder="Please provide any additional details about your symptoms..."></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-purple" id="backToStep1">
                                            <i class="fas fa-arrow-left me-1"></i> Back
                                        </button>
                                        <button type="button" class="btn btn-purple" id="getRecommendations">
                                            Get Recommendations
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Step 3: Results -->
                                <div class="step d-none" id="step3">
                                    <h5 class="text-purple mb-3">Recommended Medications</h5>
                                    <p class="text-muted mb-4">
                                        Based on your symptoms, here are some potential medications that might help. 
                                        Always consult with a healthcare professional before taking any medication.
                                    </p>
                                    
                                    <div class="mb-4">
                                        <h6 class="text-purple mb-2">Possible Condition: Common Cold</h6>
                                        <div class="bg-light-purple p-3 rounded">
                                            <h6 class="mb-2">Suggested Medications:</h6>
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-flex mb-2">
                                                    <span class="dot mt-2 me-2"></span>
                                                    <div>
                                                        <strong>Paracetamol</strong>
                                                        <span class="text-muted"> - For fever and pain relief</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex">
                                                    <span class="dot mt-2 me-2"></span>
                                                    <div>
                                                        <strong>Cetirizine</strong>
                                                        <span class="text-muted"> - For runny nose and sneezing</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h6 class="text-purple mb-2">Possible Condition: Seasonal Allergies</h6>
                                        <div class="bg-light-purple p-3 rounded">
                                            <h6 class="mb-2">Suggested Medications:</h6>
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-flex mb-2">
                                                    <span class="dot mt-2 me-2"></span>
                                                    <div>
                                                        <strong>Loratadine</strong>
                                                        <span class="text-muted"> - For allergy symptoms</span>
                                                    </div>
                                                </li>
                                                <li class="d-flex">
                                                    <span class="dot mt-2 me-2"></span>
                                                    <div>
                                                        <strong>Nasal Spray</strong>
                                                        <span class="text-muted"> - For nasal congestion</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-purple" id="startOver">
                                            Start Over
                                        </button>
                                        <button type="button" class="btn btn-purple">
                                            Search These Medications
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const goToStep2 = document.getElementById('goToStep2');
        const backToStep1 = document.getElementById('backToStep1');
        const getRecommendations = document.getElementById('getRecommendations');
        const startOver = document.getElementById('startOver');
        const symptomCheckboxes = document.querySelectorAll('.symptom-checkbox');
        const durationRadios = document.querySelectorAll('.duration-radio');
        
        // Check if at least one symptom and duration is selected
        function checkStep1Validity() {
            let hasSymptom = false;
            let hasDuration = false;
            
            symptomCheckboxes.forEach(checkbox => {
                if (checkbox.checked) hasSymptom = true;
            });
            
            durationRadios.forEach(radio => {
                if (radio.checked) hasDuration = true;
            });
            
            goToStep2.disabled = !(hasSymptom && hasDuration);
        }
        
        // Event listeners for checkboxes and radios
        symptomCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', checkStep1Validity);
        });
        
        durationRadios.forEach(radio => {
            radio.addEventListener('change', checkStep1Validity);
        });
        
        // Navigation between steps
        goToStep2.addEventListener('click', function() {
            step1.classList.add('d-none');
            step2.classList.remove('d-none');
        });
        
        backToStep1.addEventListener('click', function() {
            step2.classList.add('d-none');
            step1.classList.remove('d-none');
        });
        
        getRecommendations.addEventListener('click', function() {
            step2.classList.add('d-none');
            step3.classList.remove('d-none');
        });
        
        startOver.addEventListener('click', function() {
            // Reset form
            symptomCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            durationRadios.forEach(radio => {
                radio.checked = false;
            });
            
            document.getElementById('additionalInfo').value = '';
            
            // Go back to step 1
            step3.classList.add('d-none');
            step1.classList.remove('d-none');
            
            // Disable next button
            goToStep2.disabled = true;
        });
    });
</script>
@endsection
