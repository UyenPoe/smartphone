import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import '../../../core/constants/app_colors.dart';
import '../../../data/models/phone_model.dart';
import '../../../data/services/api_service.dart';

class B2CPriceListScreen extends StatefulWidget {
  final Function(int)? onNavigateToValuation;

  const B2CPriceListScreen({super.key, this.onNavigateToValuation});

  @override
  State<B2CPriceListScreen> createState() => _B2CPriceListScreenState();
}

class _B2CPriceListScreenState extends State<B2CPriceListScreen> {
  final ApiService _apiService = ApiService();
  final NumberFormat _currencyFormat = NumberFormat('#,###', 'vi_VN');
  final TextEditingController _searchController = TextEditingController();

  List<PhoneModel> _phones = [];
  List<PhoneModel> _filteredPhones = [];
  String _selectedBrand = 'apple';
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadModels();
  }

  Future<void> _loadModels() async {
    setState(() => _isLoading = true);
    final list = await _apiService.fetchModels(brandSlug: _selectedBrand);
    if (mounted) {
      setState(() {
        _phones = list;
        _filteredPhones = list;
        _isLoading = false;
      });
    }
  }

  void _onSearch(String query) {
    if (query.isEmpty) {
      setState(() => _filteredPhones = _phones);
    } else {
      setState(() {
        _filteredPhones = _phones
            .where((p) => p.name.toLowerCase().contains(query.toLowerCase()))
            .toList();
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: const Text('Bảng Giá Thu Mua (300+ Máy)'),
      ),
      body: Column(
        children: [
          // Search & Brand Filter Bar
          Container(
            color: Colors.white,
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
            child: Column(
              children: [
                TextField(
                  controller: _searchController,
                  onChanged: _onSearch,
                  decoration: InputDecoration(
                    hintText: 'Tìm kiếm model máy (vd: iPhone 15, S24...)',
                    prefixIcon: const Icon(Icons.search, size: 20),
                    suffixIcon: _searchController.text.isNotEmpty
                        ? IconButton(
                            icon: const Icon(Icons.clear, size: 18),
                            onPressed: () {
                              _searchController.clear();
                              _onSearch('');
                            },
                          )
                        : null,
                    contentPadding: const EdgeInsets.symmetric(vertical: 0),
                  ),
                ),
                const SizedBox(height: 8),
                Row(
                  children: [
                    _buildBrandChip('Apple', 'apple'),
                    _buildBrandChip('Samsung', 'samsung'),
                    _buildBrandChip('Xiaomi', 'xiaomi'),
                    _buildBrandChip('OPPO', 'oppo'),
                  ],
                ),
              ],
            ),
          ),

          // Price List
          Expanded(
            child: _isLoading
                ? const Center(child: CircularProgressIndicator(color: AppColors.primary))
                : _filteredPhones.isEmpty
                    ? const Center(child: Text('Không tìm thấy model phù hợp'))
                    : ListView.separated(
                        padding: const EdgeInsets.all(16),
                        itemCount: _filteredPhones.length,
                        separatorBuilder: (_, __) => const SizedBox(height: 12),
                        itemBuilder: (context, index) {
                          final phone = _filteredPhones[index];
                          return _buildPriceCard(phone);
                        },
                      ),
          ),
        ],
      ),
    );
  }

  Widget _buildBrandChip(String label, String slug) {
    final isSel = _selectedBrand == slug;
    return Padding(
      padding: const EdgeInsets.only(right: 6),
      child: FilterChip(
        label: Text(label),
        selected: isSel,
        selectedColor: AppColors.primary,
        backgroundColor: AppColors.background,
        labelStyle: TextStyle(
          color: isSel ? Colors.white : AppColors.textPrimary,
          fontSize: 11,
          fontWeight: isSel ? FontWeight.bold : FontWeight.w500,
        ),
        onSelected: (_) {
          setState(() => _selectedBrand = slug);
          _loadModels();
        },
      ),
    );
  }

  Widget _buildPriceCard(PhoneModel phone) {
    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: AppColors.border),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.between,
            children: [
              Expanded(
                child: Text(
                  phone.name,
                  style: const TextStyle(fontSize: 15, fontWeight: FontWeight.w900),
                ),
              ),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                decoration: BoxDecoration(
                  color: AppColors.primaryContainer,
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Text(
                  'Trợ giá +${_currencyFormat.format(phone.tradeinSubsidy)}đ',
                  style: const TextStyle(fontSize: 10, fontWeight: FontWeight.bold, color: AppColors.primary),
                ),
              ),
            ],
          ),
          const SizedBox(height: 10),

          // Grade Comparison Row
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              _buildGradeCol('Grade A (99%)', phone.priceGradeA, AppColors.gradeA),
              _buildGradeCol('Grade B (95%)', phone.priceGradeB, AppColors.gradeB),
              _buildGradeCol('Grade C (90%)', phone.priceGradeC, AppColors.gradeC),
              _buildGradeCol('Grade D (Lỗi)', phone.priceGradeD, AppColors.gradeD),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildGradeCol(String label, double price, Color color) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(label, style: TextStyle(fontSize: 10, color: Colors.grey[600])),
        const SizedBox(height: 2),
        Text(
          '${_currencyFormat.format(price)}đ',
          style: TextStyle(fontSize: 11.5, fontWeight: FontWeight.w900, color: color),
        ),
      ],
    );
  }
}
