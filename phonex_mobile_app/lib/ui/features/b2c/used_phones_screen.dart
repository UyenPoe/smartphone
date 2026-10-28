import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import '../../../core/constants/app_colors.dart';
import '../../../data/models/phone_model.dart';
import '../../../data/services/api_service.dart';

class B2CUsedPhonesScreen extends StatefulWidget {
  const B2CUsedPhonesScreen({super.key});

  @override
  State<B2CUsedPhonesScreen> createState() => _B2CUsedPhonesScreenState();
}

class _B2CUsedPhonesScreenState extends State<B2CUsedPhonesScreen> {
  final ApiService _apiService = ApiService();
  final NumberFormat _currencyFormat = NumberFormat('#,###', 'vi_VN');

  List<PhoneModel> _phones = [];
  PhoneModel? _selectedPhoneForInstallment;
  double _prepayPercent = 0.20; // Trả trước 20%
  int _tenureMonths = 6; // Kỳ hạn 6 tháng
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadPhones();
  }

  Future<void> _loadPhones() async {
    final list = await _apiService.fetchModels(brandSlug: 'apple');
    if (mounted && list.isNotEmpty) {
      setState(() {
        _phones = list;
        _selectedPhoneForInstallment = list.first;
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    final phonePrice = _selectedPhoneForInstallment?.priceGradeA ?? 20000000;
    final prepayAmount = phonePrice * _prepayPercent;
    final loanAmount = phonePrice - prepayAmount;
    final monthlyAmount = loanAmount / _tenureMonths;

    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: const Text('Kho Máy Cũ & Trả Góp 0%'),
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator(color: AppColors.primary))
          : SingleChildScrollView(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // 1. INSTALLMENT CALCULATOR WIDGET
                  Container(
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(20),
                      border: Border.all(color: AppColors.primary.withValues(alpha: 0.3), width: 1.5),
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Row(
                          children: [
                            Icon(Icons.credit_card, color: AppColors.primary, size: 22),
                            SizedBox(width: 8),
                            Text(
                              'Tính Tiền Trả Góp 0% Lãi Suất',
                              style: TextStyle(fontSize: 15, fontWeight: FontWeight.w900),
                            ),
                          ],
                        ),
                        const SizedBox(height: 12),
                        DropdownButtonFormField<PhoneModel>(
                          initialValue: _selectedPhoneForInstallment,
                          decoration: const InputDecoration(labelText: 'Chọn máy bạn muốn mua góp'),
                          items: _phones.map((p) => DropdownMenuItem(value: p, child: Text(p.name))).toList(),
                          onChanged: (val) {
                            if (val != null) setState(() => _selectedPhoneForInstallment = val);
                          },
                        ),
                        const SizedBox(height: 14),

                        // Prepay Slider
                        Text(
                          'Trả trước: ${( _prepayPercent * 100 ).toInt()}% (${_currencyFormat.format(prepayAmount)}đ)',
                          style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold),
                        ),
                        Slider(
                          value: _prepayPercent,
                          min: 0.0,
                          max: 0.5,
                          divisions: 5,
                          activeColor: AppColors.primary,
                          onChanged: (val) => setState(() => _prepayPercent = val),
                        ),

                        // Tenure Selector
                        const Text('Kỳ hạn vay góp:', style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold)),
                        const SizedBox(height: 6),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [3, 6, 9, 12].map((m) {
                            final isSel = _tenureMonths == m;
                            return ChoiceChip(
                              label: Text('$m Tháng'),
                              selected: isSel,
                              selectedColor: AppColors.primary,
                              onSelected: (_) => setState(() => _tenureMonths = m),
                              labelStyle: TextStyle(
                                color: isSel ? Colors.white : AppColors.textPrimary,
                                fontWeight: FontWeight.bold,
                                fontSize: 11,
                              ),
                            );
                          }).toList(),
                        ),

                        const Divider(height: 24),

                        // Result Row
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            const Text('Góp mỗi tháng:', style: TextStyle(fontSize: 13, fontWeight: FontWeight.w700)),
                            Text(
                              '${_currencyFormat.format(monthlyAmount)}đ/tháng',
                              style: const TextStyle(fontSize: 17, fontWeight: FontWeight.w900, color: AppColors.primary),
                            ),
                          ],
                        ),
                        const SizedBox(height: 12),
                        SizedBox(
                          width: double.infinity,
                          child: ElevatedButton(
                            onPressed: () {
                              ScaffoldMessenger.of(context).showSnackBar(
                                const SnackBar(content: Text('Đang kết nối cổng duyệt hồ sơ CCCD trong 5 phút...')),
                              );
                            },
                            child: const Text('NỘP HỒ SƠ DUYỆT 5 PHÚT (CCCD)'),
                          ),
                        ),
                      ],
                    ),
                  ),

                  const SizedBox(height: 20),

                  // 2. PRE-OWNED CATALOG LIST
                  const Text(
                    'Kho Máy Cũ Like New 99% Sẵn Hàng',
                    style: TextStyle(fontSize: 16, fontWeight: FontWeight.w900),
                  ),
                  const SizedBox(height: 12),

                  ListView.separated(
                    shrinkWrap: true,
                    physics: const NeverScrollableScrollPhysics(),
                    itemCount: _phones.length,
                    separatorBuilder: (_, __) => const SizedBox(height: 10),
                    itemBuilder: (context, index) {
                      final p = _phones[index];
                      return Container(
                        padding: const EdgeInsets.all(12),
                        decoration: BoxDecoration(
                          color: Colors.white,
                          borderRadius: BorderRadius.circular(14),
                          border: Border.all(color: AppColors.border),
                        ),
                        child: Row(
                          children: [
                            Container(
                              width: 60,
                              height: 60,
                              decoration: BoxDecoration(
                                color: AppColors.background,
                                borderRadius: BorderRadius.circular(10),
                              ),
                              child: const Icon(Icons.smartphone, color: Colors.grey),
                            ),
                            const SizedBox(width: 12),
                            Expanded(
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(p.name, style: const TextStyle(fontWeight: FontWeight.w800, fontSize: 13)),
                                  const SizedBox(height: 2),
                                  Text('Bảo hành 12 tháng 1 đổi 1', style: TextStyle(fontSize: 10.5, color: Colors.grey[600])),
                                  const SizedBox(height: 4),
                                  Text(
                                    '${_currencyFormat.format(p.priceGradeA)}đ',
                                    style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w900, color: AppColors.primary),
                                  ),
                                ],
                              ),
                            ),
                            ElevatedButton(
                              onPressed: () => setState(() => _selectedPhoneForInstallment = p),
                              style: ElevatedButton.styleFrom(
                                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
                                textStyle: const TextStyle(fontSize: 11),
                              ),
                              child: const Text('Chọn góp'),
                            ),
                          ],
                        ),
                      );
                    },
                  ),
                ],
              ),
            ),
    );
  }
}
