class Brand {
  final int id;
  final String name;
  final String slug;
  final String logoUrl;
  final int modelCount;

  Brand({
    required this.id,
    required this.name,
    required this.slug,
    required this.logoUrl,
    required this.modelCount,
  });

  factory Brand.fromJson(Map<String, dynamic> json) {
    return Brand(
      id: json['id'] is int ? json['id'] : int.tryParse(json['id'].toString()) ?? 0,
      name: json['name'] ?? '',
      slug: json['slug'] ?? '',
      logoUrl: json['logo'] ?? json['logo_url'] ?? '',
      modelCount: json['model_count'] is int 
          ? json['model_count'] 
          : int.tryParse(json['model_count']?.toString() ?? '0') ?? 0,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'slug': slug,
      'logo': logoUrl,
      'model_count': modelCount,
    };
  }
}
