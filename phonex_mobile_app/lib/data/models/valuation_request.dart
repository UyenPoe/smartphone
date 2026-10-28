class ValuationRequest {
  final String modelName;
  final String modelSlug;
  final String capacity;
  final String bodyGrade;   // grade_a, grade_b, grade_c
  final String screenGrade; // grade_a, grade_b, grade_c
  final String batteryHealth; // above_85, 80_85, below_80
  final String origin;      // vna, international
  final String partnerId;
  final double estimatedPrice;
  final String grade;
  final double subsidy;
  final double totalBenefit;

  ValuationRequest({
    required this.modelName,
    required this.modelSlug,
    required this.capacity,
    required this.bodyGrade,
    required this.screenGrade,
    this.batteryHealth = 'above_85',
    this.origin = 'vna',
    this.partnerId = '',
    required this.estimatedPrice,
    required this.grade,
    this.subsidy = 1500000,
    required this.totalBenefit,
  });

  Map<String, dynamic> toJson() {
    return {
      'model_slug': modelSlug,
      'capacity': capacity,
      'body_grade': bodyGrade,
      'screen_grade': screenGrade,
      'battery_health': batteryHealth,
      'origin': origin,
      'partner_id': partnerId,
    };
  }
}

class BuybackTicket {
  final String ticketCode;
  final String customerName;
  final String customerPhone;
  final String deviceName;
  final double estimatedPrice;
  final double finalPrice;
  final String grade;
  final String status;
  final String createdAt;

  BuybackTicket({
    required this.ticketCode,
    required this.customerName,
    required this.customerPhone,
    required this.deviceName,
    required this.estimatedPrice,
    required this.finalPrice,
    required this.grade,
    required this.status,
    required this.createdAt,
  });

  factory BuybackTicket.fromJson(Map<String, dynamic> json) {
    return BuybackTicket(
      ticketCode: json['request_code'] ?? json['ticket_code'] ?? 'PX-TM-UNKNOWN',
      customerName: json['customer_name'] ?? 'Khách hàng',
      customerPhone: json['customer_phone'] ?? '',
      deviceName: json['device_model'] ?? json['device_name'] ?? '',
      estimatedPrice: (json['estimated_price'] ?? 0).toDouble(),
      finalPrice: (json['final_price'] ?? json['estimated_price'] ?? 0).toDouble(),
      grade: json['final_grade'] ?? json['grade'] ?? 'Grade A',
      status: json['status'] ?? 'pending_inspection',
      createdAt: json['created_at'] ?? 'Hôm nay',
    );
  }
}
