// PRICE
$( "#slider-range-price" ).slider({
    range: true,
    min: 0,
    max: 30000,
    values: [ 5000, 25000 ],
    slide: function( event, ui ) {
      $(  "#sra-price-first-value" ).val( ui.values[ 0 ] );
      $(  "#sra-price-second-value" ).val( ui.values[ 1 ] );
    }
});
$(  "#sra-price-first-value" ).val( $( "#slider-range-price" ).slider( "values", 0 ));
$(  "#sra-price-second-value" ).val($( "#slider-range-price" ).slider( "values", 1 ));

// LOAN
$( "#slider-range-loan" ).slider({
    range: true,
    min: 0,
    max: 100,
    values: [ 20, 80 ],
    slide: function( event, ui ) {
      $(  "#sra-loan-first-value" ).val( ui.values[ 0 ] );
      $(  "#sra-loan-second-value" ).val( ui.values[ 1 ] );
    }
});
$(  "#sra-loan-first-value" ).val( $( "#slider-range-loan" ).slider( "values", 0 ));
$(  "#sra-loan-second-value" ).val($( "#slider-range-loan" ).slider( "values", 1 ));

// Percent Benefit
$( "#slider-range-per-benefit" ).slider({
    range: true,
    min: 0,
    max: 100,
    values: [ 0, 0 ],
    slide: function( event, ui ) {
      $(  "#sra-per-benefit-first-value" ).val( ui.values[ 0 ] );
      $(  "#sra-per-benefit-second-value" ).val( ui.values[ 1 ] );
    }
});
$(  "#sra-per-benefit-first-value" ).val( $( "#slider-range-per-benefit" ).slider( "values", 0 ));
$(  "#sra-per-benefit-second-value" ).val($( "#slider-range-per-benefit" ).slider( "values", 1 ));

// Funding
$( "#slider-range-funding" ).slider({
    range: true,
    min: 0,
    max: 100,
    values: [ 0, 0 ],
    slide: function( event, ui ) {
      $(  "#sra-funding-first-value" ).val( ui.values[ 0 ] );
      $(  "#sra-funding-second-value" ).val( ui.values[ 1 ] );
    }
});
$(  "#sra-funding-first-value" ).val( $( "#slider-range-funding" ).slider( "values", 0 ));
$(  "#sra-funding-second-value" ).val($( "#slider-range-funding" ).slider( "values", 1 ));