import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import '../../../core/constants/app_colors.dart';
import '../../../data/models/valuation_request.dart';
import '../../../data/services/api_service.dart';

class B2CTrackingScreen extends StatefulWidget {
  const B2CTrackingScreen({super.key});

  @override
  State<B2CTrackingScreen> createState() => _B2CTrackingScreenState();
}

class _B2CTrackingScreenState extends State<B2CTrackingScreen> {
  final ApiService _apiService = ApiService();
  final NumberFormat _currencyFormat = NumberFormat('#,###', 'vi_VN');
  final _phoneController = TextEditingController(text: '0901234567');

  List<BuybackTicket> _tickets = [];
  bool _isLoading = false;
  bool _searched = false;

  Future<void> _lookup() async {
    if (_phoneController.text.isEmpty) return;
    setState(() {
      _isLoading = true;
      _searched = true;
    });

    final res = await _apiService.lookupTickets(_phoneController.text);
    if (mounted) {
      setState(() {
        _tickets = res;
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: const Text('Tra Cứu Đơn Thu & Bảo Hành'),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Search Input Card
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(16),
                border: Border.all(color: AppColors.border),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    'Nhập số điện thoại để tra cứu tiến độ:',
                    style: TextStyle(fontSize: 13, fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 10),
                  Row(
                    children: [
                      Expanded(
                        child: TextField(
                          controller: _phoneController,
                          keyboardType: TextInputType.phone,
                          decoration: const InputDecoration(
                            hintText: 'Nhập SĐT (vd: 0901234567)',
                            prefixIcon: Icon(Icons.phone, size: 20),
                            contentPadding: EdgeInsets.symmetric(vertical: 0),
                          ),
                        ),
                      ),
                      const SizedBox(width: 10),
                      ElevatedButton(
                        onPressed: _lookup,
                        child: _isLoading
                            ? const SizedBox(width: 16, height: 16, child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2))
                            : const Text('TRA CỨU'),
                      ),
                    ],
                  ),
                ],
              ),
            ),

            const SizedBox(height: 20),

            if (_searched) ...[
              Text(
                'Kết quả tra cứu (${_tickets.length} hồ sơ):',
                style: const TextStyle(fontSize: 15, fontWeight: FontWeight.w900),
              ),
              const SizedBox(height: 10),

              if (_tickets.isEmpty)
                const Center(
                  child: Padding(
                    padding: EdgeInsets.all(32),
                    child: Text('Không tìm thấy phiếu thu nào gắn với số điện thoại này.'),
                  ),
                )
              else
                ListView.separated(
                  shrinkWrap: true,
                  physics: const NeverScrollableScrollPhysics(),
                  itemCount: _tickets.length,
                  separatorBuilder: (_, __) => const SizedBox(height: 12),
                  itemBuilder: (context, index) {
                    final t = _tickets[index];
                    return _buildTicketCard(t);
                  },
                ),
            ],
          ],
        ),
      ),
    );
  }

  Widget _buildTicketCard(BuybackTicket t) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: AppColors.border),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                t.ticketCode,
                style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w900, color: AppColors.primary),
              ),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                decoration: BoxDecoration(
                  color: Colors.blue.withValues(alpha: 0.12),
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Text(
                  t.status,
                  style: const TextStyle(fontSize: 10.5, fontWeight: FontWeight.w800, color: Colors.blue),
                ),
              ),
            ],
          ),
          const SizedBox(height: 8),
          Text(t.deviceName, style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold)),
          const SizedBox(height: 4),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text('Kết quả thẩm định:', style: TextStyle(fontSize: 11, color: Colors.grey[600])),
              Text(t.grade, style: const TextStyle(fontSize: 11, fontWeight: FontWeight.bold, color: AppColors.gradeA)),
            ],
          ),
          const SizedBox(height: 4),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text('Số tiền giải ngân:', style: TextStyle(fontSize: 11, color: Colors.grey[600])),
              Text('${_currencyFormat.format(t.finalPrice)}đ', style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w900, color: AppColors.primary)),
            ],
          ),
          const Divider(height: 18),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text('Thời gian: ${t.createdAt}', style: TextStyle(fontSize: 10.5, color: Colors.grey[500])),
              const Text('Showroom TP.HCM', style: TextStyle(fontSize: 10.5, fontWeight: FontWeight.w600)),
            ],
          ),
        ],
      ),
    );
  }
}
