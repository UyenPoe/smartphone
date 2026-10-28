import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import '../../../core/constants/app_colors.dart';
import '../../../data/models/brand.dart';
import '../../../data/models/phone_model.dart';
import '../../../data/services/api_service.dart';

class B2CHomeScreen extends StatefulWidget {
  final Function(int) onTabChange;

  const B2CHomeScreen({super.key, required this.onTabChange});

  @override
  State<B2CHomeScreen> createState() => _B2CHomeScreenState();
}

class _B2CHomeScreenState extends State<B2CHomeScreen> {
  final ApiService _apiService = ApiService();
  final NumberFormat _currencyFormat = NumberFormat('#,###', 'vi_VN');

  List<Brand> _brands = [];
  List<PhoneModel> _featuredPhones = [];
  String _selectedBrand = 'apple';
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadData();
  }

  Future<void> _loadData() async {
    setState(() => _isLoading = true);
    final brands = await _apiService.fetchBrands();
    final phones = await _apiService.fetchModels(brandSlug: _selectedBrand);
    if (mounted) {
      setState(() {
        _brands = brands;
        _featuredPhones = phones;
        _isLoading = false;
      });
    }
  }

  Future<void> _onBrandSelect(String slug) async {
    setState(() {
      _selectedBrand = slug;
      _isLoading = true;
    });
    final phones = await _apiService.fetchModels(brandSlug: slug);
    if (mounted) {
      setState(() {
        _featuredPhones = phones;
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      body: RefreshIndicator(
        onRefresh: _loadData,
        color: AppColors.primary,
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // 1. HERO TRADE-IN BANNER
              _buildHeroBanner(),

              const SizedBox(height: 16),

              // 2. 4 QUICK ACTION TILES
              _buildQuickActions(),

              const SizedBox(height: 20),

              // 3. BRAND HORIZONTAL SELECTOR
              _buildBrandSelector(),

              const SizedBox(height: 16),

              // 4. TOP BUYBACK MODELS GRID
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text(
                    'Bảng Giá Thu Mua Nổi Bật',
                    style: TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.w900,
                      color: AppColors.textPrimary,
                    ),
                  ),
                  TextButton(
                    onPressed: () => widget.onTabChange(1), // Chuyển sang Tab Bảng giá
                    child: const Text(
                      'Xem tất cả (300+) >',
                      style: TextStyle(
                        color: AppColors.primary,
                        fontWeight: FontWeight.w700,
                        fontSize: 12,
                      ),
                    ),
                  ),
                ],
              ),

              const SizedBox(height: 8),

              if (_isLoading)
                const Center(
                  child: Padding(
                    padding: EdgeInsets.all(32),
                    child: CircularProgressIndicator(color: AppColors.primary),
                  ),
                )
              else
                _buildPhoneGrid(),

              const SizedBox(height: 24),

              // 5. COMMITMENT BANNER (30 BƯỚC TEST & GIẢI NGÂN 5P)
              _buildTrustBadges(),

              const SizedBox(height: 20),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildHeroBanner() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(18),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [AppColors.primary, AppColors.primaryDark],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: AppColors.primary.withValues(alpha: 0.3),
            blurRadius: 16,
            offset: const Offset(0, 6),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
            decoration: BoxDecoration(
              color: Colors.white.withValues(alpha: 0.2),
              borderRadius: BorderRadius.circular(20),
            ),
            child: const Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Icon(Icons.bolt, color: Colors.amber, size: 14),
                SizedBox(width: 4),
                Text(
                  'ĐỊNH GIÁ AI TRỰC TUYẾN 30 GIÂY',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 10,
                    fontWeight: FontWeight.w900,
                    letterSpacing: 0.5,
                  ),
                ),
              ],
            ),
          ),
          const SizedBox(height: 10),
          const Text(
            'Thu Cũ Giá Cao Nhất Thị Trường\nTrợ Giá Lên Đời Đến 3.000.000đ',
            style: TextStyle(
              color: Colors.white,
              fontSize: 17,
              fontWeight: FontWeight.w900,
              height: 1.3,
            ),
          ),
          const SizedBox(height: 12),
          ElevatedButton(
            onPressed: () => widget.onTabChange(2), // Mở Tab Định giá 30s
            style: ElevatedButton.styleFrom(
              backgroundColor: Colors.white,
              foregroundColor: AppColors.primary,
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(12),
              ),
            ),
            child: const Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Icon(Icons.calculate, size: 16),
                SizedBox(width: 6),
                Text(
                  'ĐỊNH GIÁ MÁY NGAY',
                  style: TextStyle(fontWeight: FontWeight.w900, fontSize: 12),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildQuickActions() {
    final actions = [
      {'title': 'Định giá 30s', 'icon': Icons.calculate, 'color': AppColors.primary, 'tab': 2},
      {'title': 'Bảng giá 300+', 'icon': Icons.table_chart, 'color': Colors.blue, 'tab': 1},
      {'title': 'Kho máy 99%', 'icon': Icons.inventory_2, 'color': Colors.amber[800], 'tab': 3},
      {'title': 'Trả góp 0%', 'icon': Icons.credit_card, 'color': const Color(0xFF10B981), 'tab': 3},
    ];

    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: actions.map((act) {
        return Expanded(
          child: GestureDetector(
            onTap: () => widget.onTabChange(act['tab'] as int),
            child: Container(
              margin: const EdgeInsets.symmetric(horizontal: 3),
              padding: const EdgeInsets.symmetric(vertical: 12),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(14),
                border: Border.all(color: AppColors.border),
              ),
              child: Column(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Icon(act['icon'] as IconData, color: act['color'] as Color?, size: 24),
                  const SizedBox(height: 6),
                  Text(
                    act['title'] as String,
                    style: const TextStyle(
                      fontSize: 11,
                      fontWeight: FontWeight.w700,
                      color: AppColors.textPrimary,
                    ),
                  ),
                ],
              ),
            ),
          ),
        );
      }).toList(),
    );
  }

  Widget _buildBrandSelector() {
    return SizedBox(
      height: 38,
      child: ListView.builder(
        scrollDirection: Axis.horizontal,
        itemCount: _brands.length,
        itemBuilder: (context, index) {
          final b = _brands[index];
          final isSelected = b.slug == _selectedBrand;
          return Padding(
            padding: const EdgeInsets.only(right: 8),
            child: ChoiceChip(
              label: Text(b.name),
              selected: isSelected,
              onSelected: (_) => _onBrandSelect(b.slug),
              selectedColor: AppColors.primary,
              backgroundColor: Colors.white,
              labelStyle: TextStyle(
                color: isSelected ? Colors.white : AppColors.textPrimary,
                fontWeight: isSelected ? FontWeight.w800 : FontWeight.w600,
                fontSize: 12,
              ),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(20),
                side: BorderSide(
                  color: isSelected ? AppColors.primary : AppColors.border,
                ),
              ),
            ),
          );
        },
      ),
    );
  }

  Widget _buildPhoneGrid() {
    return GridView.builder(
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      itemCount: _featuredPhones.length,
      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
        crossAxisCount: 2,
        mainAxisSpacing: 10,
        crossAxisSpacing: 10,
        childAspectRatio: 0.72,
      ),
      itemBuilder: (context, index) {
        final phone = _featuredPhones[index];
        return Container(
          padding: const EdgeInsets.all(12),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(16),
            border: Border.all(color: AppColors.border),
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Phone Image Placeholder / Network
              Expanded(
                child: Center(
                  child: Container(
                    padding: const EdgeInsets.all(8),
                    decoration: BoxDecoration(
                      color: AppColors.background,
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: const Icon(
                      Icons.smartphone,
                      size: 64,
                      color: Color(0xFF64748B),
                    ),
                  ),
                ),
              ),
              const SizedBox(height: 8),
              Text(
                phone.name,
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
                style: const TextStyle(
                  fontWeight: FontWeight.w800,
                  fontSize: 13,
                  color: AppColors.textPrimary,
                ),
              ),
              const SizedBox(height: 4),
              Row(
                children: [
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 5, vertical: 1.5),
                    decoration: BoxDecoration(
                      color: AppColors.gradeA.withValues(alpha: 0.12),
                      borderRadius: BorderRadius.circular(4),
                    ),
                    child: const Text(
                      'Grade A',
                      style: TextStyle(
                        fontSize: 9.5,
                        fontWeight: FontWeight.w800,
                        color: AppColors.gradeA,
                      ),
                    ),
                  ),
                  const SizedBox(width: 4),
                  Text(
                    'Trợ giá +${_currencyFormat.format(phone.tradeinSubsidy)}đ',
                    style: const TextStyle(
                      fontSize: 9.5,
                      fontWeight: FontWeight.w700,
                      color: AppColors.primary,
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 6),
              Text(
                'Giá thu đến:',
                style: TextStyle(fontSize: 10, color: Colors.grey[600]),
              ),
              Text(
                '${_currencyFormat.format(phone.priceGradeA)}đ',
                style: const TextStyle(
                  fontSize: 14,
                  fontWeight: FontWeight.w900,
                  color: AppColors.primary,
                ),
              ),
            ],
          ),
        );
      },
    );
  }

  Widget _buildTrustBadges() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: AppColors.border),
      ),
      child: Column(
        children: [
          _buildTrustRow(Icons.verified, 'Kiểm định 30 bước công khai', 'Minh bạch tình trạng Grade A/B/C/D'),
          const Divider(height: 20),
          _buildTrustRow(Icons.payments, 'Thanh toán chuyển khoản 5 phút', 'Nhận đủ 100% tiền ngay khi chốt giá'),
          const Divider(height: 20),
          _buildTrustRow(Icons.lock_reset, 'Xóa vĩnh viễn dữ liệu cá nhân', 'Tiêu chuẩn bảo mật DoD 5220.22-M'),
        ],
      ),
    );
  }

  Widget _buildTrustRow(IconData icon, String title, String subtitle) {
    return Row(
      children: [
        Container(
          width: 36,
          height: 36,
          decoration: BoxDecoration(
            color: AppColors.primaryContainer,
            borderRadius: BorderRadius.circular(10),
          ),
          child: Icon(icon, color: AppColors.primary, size: 20),
        ),
        const SizedBox(width: 12),
        Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              title,
              style: const TextStyle(fontSize: 12, fontWeight: FontWeight.w800),
            ),
            Text(
              subtitle,
              style: const TextStyle(fontSize: 10.5, color: AppColors.textSecondary),
            ),
          ],
        ),
      ],
    );
  }
}
