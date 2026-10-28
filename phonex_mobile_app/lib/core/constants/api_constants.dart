class ApiConstants {
  static const String baseUrl = 'https://smartphone.taichinhtaithanh.com/wp-json/phonex/v1';

  // Buyback Endpoints
  static const String buybackBrands = '$baseUrl/buyback/brands';
  static const String buybackModels = '$baseUrl/buyback/models';
  static const String buybackSearch = '$baseUrl/buyback/search';
  static const String buybackEstimate = '$baseUrl/buyback/estimate';
  static const String buybackSubmit = '$baseUrl/buyback/submit-request';
  static const String buybackLookup = '$baseUrl/buyback/lookup';

  // Hotlines
  static const String hotlineRetail = '18006868';
  static const String hotlineTechnical = '18006869';
  static const String hotlineB2B = '18006870';
  static const String emailB2B = 'api@phonex.vn';
}
