class PhoneModel {
  final String id;
  final String name;
  final String slug;
  final String brand;
  final String imageUrl;
  final List<String> capacities;
  final double priceGradeA;
  final double priceGradeB;
  final double priceGradeC;
  final double priceGradeD;
  final double tradeinSubsidy;
  final double wholesalePrice; // B2B Price
  final int wholesaleStock;

  PhoneModel({
    required this.id,
    required this.name,
    required this.slug,
    required this.brand,
    required this.imageUrl,
    required this.capacities,
    required this.priceGradeA,
    required this.priceGradeB,
    required this.priceGradeC,
    required this.priceGradeD,
    this.tradeinSubsidy = 1500000,
    required this.wholesalePrice,
    this.wholesaleStock = 12,
  });

  factory PhoneModel.fromJson(Map<String, dynamic> json) {
    final pricing = json['pricing'] is Map ? json['pricing'] : {};
    final caps = json['capacities'] is List
        ? (json['capacities'] as List).map((e) => e.toString()).toList()
        : ['128GB', '256GB'];

    final gradeA = (pricing['grade_a'] ?? json['price_grade_a'] ?? json['price'] ?? 0).toDouble();
    final gradeB = (pricing['grade_b'] ?? json['price_grade_b'] ?? (gradeA * 0.9)).toDouble();
    final gradeC = (pricing['grade_c'] ?? json['price_grade_c'] ?? (gradeA * 0.8)).toDouble();
    final gradeD = (pricing['grade_d'] ?? json['price_grade_d'] ?? (gradeA * 0.65)).toDouble();

    return PhoneModel(
      id: json['id']?.toString() ?? json['slug'] ?? '',
      name: json['name'] ?? '',
      slug: json['slug'] ?? '',
      brand: json['brand'] ?? '',
      imageUrl: json['image_url'] ?? json['image'] ?? '',
      capacities: caps,
      priceGradeA: gradeA,
      priceGradeB: gradeB,
      priceGradeC: gradeC,
      priceGradeD: gradeD,
      tradeinSubsidy: (json['tradein_subsidy'] ?? 1500000).toDouble(),
      wholesalePrice: (json['wholesale_price'] ?? (gradeA * 0.88)).toDouble(),
      wholesaleStock: json['wholesale_stock'] ?? 15,
    );
  }
}
