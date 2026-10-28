import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import '../../../core/constants/app_colors.dart';
import '../../../data/models/phone_model.dart';
import '../../../data/services/api_service.dart';

class B2BWholesaleScreen extends StatefulWidget {
  const B2BWholesaleScreen({super.key});

  @override
  State<B2BWholesaleScreen> createState() => _B2BWholesaleScreenState();
}

class _B2BWholesaleScreenState extends State<B2BWholesaleScreen> {
  final ApiService _apiService = ApiService();
  final NumberFormat _currencyFormat = NumberFormat('#,###', 'vi_VN');

  List<PhoneModel> _phones = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadWholesale();
  }

  Future<void> _loadWholesale() async {
    final list = await _apiService.fetchModels(brandSlug: 'apple');
    if (mounted) {
      setState(() {
        _phones = list;
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF1F5F9),
      appBar: AppBar(
        backgroundColor: AppColors.b2bPrimary,
        title: const Text('Kho Sỉ B2B PhoneX (Chiết Khấu Đến 18%)', style: TextStyle(color: Colors.white, fontSize: 15)),
        actions: [
          IconButton(
            icon: const Icon(Icons.shopping_cart_outlined, color: Colors.white),
            onPressed: () {},
          ),
        ],
      ),
      body: _isLoading
          ? const Center(child: CircularProgressIndicator(color: AppColors.b2bAccent))
          : SingleChildScrollView(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // VIP Partner Banner
                  Container(
                    padding: const EdgeInsets.all(16),
                    decoration: BoxDecoration(
                      gradient: const LinearGradient(
                        colors: [Color(0xFF0F172A), Color(0xFF1E293B)],
                      ),
                      borderRadius: BorderRadius.circular(16),
                      border: Border.all(color: AppColors.b2bAccent.withValues(alpha: 0.4)),
                    ),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            const Row(
                              children: [
                                Icon(Icons.stars, color: AppColors.b2bAccent, size: 18),
                                SizedBox(width: 6),
                                Text(
                                  'CẤP ĐẠI LÝ: KIM CƯƠNG (TIER 1)',
                                  style: TextStyle(color: AppColors.b2bAccent, fontWeight: FontWeight.w900, fontSize: 11),
                                ),
                              ],
                            ),
                            const SizedBox(height: 4),
                            const Text(
                              'Chiết khấu trực tiếp 12% - 18%',
                              style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 14),
                            ),
                            const SizedBox(height: 2),
                            Text(
                              'Áp dụng đơn từ 3 máy • Hỗ trợ công nợ 15 ngày',
                              style: TextStyle(color: Colors.grey[400], fontSize: 10.5),
                            ),
                          ],
                        ),
                        Container(
                          padding: const EdgeInsets.all(8),
                          decoration: BoxDecoration(
                            color: Colors.white.withValues(alpha: 0.1),
                            borderRadius: BorderRadius.circular(10),
                          ),
                          child: const Icon(Icons.qr_code, color: Colors.white, size: 32),
                        ),
                      ],
                    ),
                  ),

                  const SizedBox(height: 16),

                  const Text(
                    'Bảng Giá Nhập Sỉ Hôm Nay (Sẵn Hàng)',
                    style: TextStyle(fontSize: 15, fontWeight: FontWeight.w900, color: Color(0xFF0F172A)),
                  ),
                  const SizedBox(height: 10),

                  ListView.separated(
                    shrinkWrap: true,
                    physics: const NeverScrollableScrollPhysics(),
                    itemCount: _phones.length,
                    separatorBuilder: (_, __) => const SizedBox(height: 10),
                    itemBuilder: (context, index) {
                      final p = _phones[index];
                      return Container(
                        padding: const EdgeInsets.all(14),
                        decoration: BoxDecoration(
                          color: Colors.white,
                          borderRadius: BorderRadius.circular(14),
                          border: Border.all(color: const Color(0xFFE2E8F0)),
                        ),
                        child: Row(
                          children: [
                            Container(
                              width: 50,
                              height: 50,
                              decoration: BoxDecoration(
                                color: const Color(0xFFF8FAFC),
                                borderRadius: BorderRadius.circular(10),
                              ),
                              child: const Icon(Icons.smartphone, color: Color(0xFF64748B)),
                            ),
                            const SizedBox(width: 12),
                            Expanded(
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(p.name, style: const TextStyle(fontWeight: FontWeight.w800, fontSize: 13)),
                                  const SizedBox(height: 2),
                                  Text('Sẵn kho sỉ: ${p.wholesaleStock} máy (Grade A 99%)', style: const TextStyle(fontSize: 10.5, color: Colors.green, fontWeight: FontWeight.bold)),
                                  const SizedBox(height: 4),
                                  Row(
                                    children: [
                                      Text(
                                        'Giá sỉ: ',
                                        style: TextStyle(fontSize: 11, color: Colors.grey[600]),
                                      ),
                                      Text(
                                        '${_currencyFormat.format(p.wholesalePrice)}đ',
                                        style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w900, color: AppColors.primary),
                                      ),
                                    ],
                                  ),
                                ],
                              ),
                            ),
                            ElevatedButton(
                              onPressed: () {
                                ScaffoldMessenger.of(context).showSnackBar(
                                  SnackBar(content: Text('Đã thêm lô ${p.name} vào danh sách đặt sỉ')),
                                );
                              },
                              style: ElevatedButton.styleFrom(
                                backgroundColor: AppColors.b2bPrimary,
                                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 8),
                                textStyle: const TextStyle(fontSize: 11, fontWeight: FontWeight.bold),
                              ),
                              child: const Text('Nhập sỉ'),
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
