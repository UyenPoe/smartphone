import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import '../../../core/constants/app_colors.dart';
import '../../../data/models/phone_model.dart';
import '../../../data/services/api_service.dart';

class B2CValuationScreen extends StatefulWidget {
  const B2CValuationScreen({super.key});

  @override
  State<B2CValuationScreen> createState() => _B2CValuationScreenState();
}

class _B2CValuationScreenState extends State<B2CValuationScreen> {
  final ApiService _apiService = ApiService();
  final NumberFormat _currencyFormat = NumberFormat('#,###', 'vi_VN');

  int _currentStep = 0; // 0: Chọn máy, 1: Ngoại hình & Màn hình, 2: Kết quả & Đặt lịch
  List<PhoneModel> _availableModels = [];
  PhoneModel? _selectedModel;
  String _selectedCapacity = '256GB';
  String _bodyGrade = 'grade_a';
  String _screenGrade = 'grade_a';
  
  // Results
  double _estimatedPrice = 0;
  double _subsidy = 1500000;
  String _assignedGrade = 'Grade A';
  bool _isCalculating = false;

  // Booking Form
  final _nameController = TextEditingController();
  final _phoneController = TextEditingController();
  final _addressController = TextEditingController();
  String _ticketCode = '';
  bool _isSuccess = false;

  @override
  void initState() {
    super.initState();
    _loadModels();
  }

  Future<void> _loadModels() async {
    final list = await _apiService.fetchModels(brandSlug: 'apple');
    if (mounted && list.isNotEmpty) {
      setState(() {
        _availableModels = list;
        _selectedModel = list.first;
        _selectedCapacity = list.first.capacities.first;
      });
    }
  }

  void _calculatePrice() {
    setState(() => _isCalculating = true);
    
    // Calculate via API / algorithm
    double base = _selectedModel?.priceGradeA ?? 20000000;
    String grade = 'Grade A (Like New 99%)';

    if (_bodyGrade == 'grade_b' || _screenGrade == 'grade_b') {
      base *= 0.90;
      grade = 'Grade B (95% trầy nhẹ)';
    }
    if (_bodyGrade == 'grade_c' || _screenGrade == 'grade_c') {
      base *= 0.78;
      grade = 'Grade C (90% cấn móp)';
    }

    setState(() {
      _estimatedPrice = base;
      _assignedGrade = grade;
      _subsidy = _selectedModel?.tradeinSubsidy ?? 1500000;
      _currentStep = 2;
      _isCalculating = false;
    });
  }

  Future<void> _submitBooking() async {
    if (_nameController.text.isEmpty || _phoneController.text.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Vui lòng điền họ tên và số điện thoại')),
      );
      return;
    }

    final res = await _apiService.submitTicket(
      customerName: _nameController.text,
      customerPhone: _phoneController.text,
      address: _addressController.text.isEmpty ? '128 Showroom PhoneX' : _addressController.text,
      deviceModel: '${_selectedModel?.name} $_selectedCapacity',
      estimatedPrice: _estimatedPrice,
    );

    setState(() {
      _ticketCode = res['request_code'] ?? 'PX-TM-261028-001';
      _isSuccess = true;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      appBar: AppBar(
        title: const Text('Định Giá Thu Cũ 30 Giây'),
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: () {
              setState(() {
                _currentStep = 0;
                _isSuccess = false;
              });
            },
            tooltip: 'Làm lại từ đầu',
          ),
        ],
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          children: [
            // STEP PROGRESS BAR
            _buildStepIndicator(),
            const SizedBox(height: 16),

            if (_isSuccess)
              _buildSuccessCard()
            else if (_currentStep == 0)
              _buildStep1DeviceSelection()
            else if (_currentStep == 1)
              _buildStep2HardwareCondition()
            else
              _buildStep3ResultAndBooking(),
          ],
        ),
      ),
    );
  }

  Widget _buildStepIndicator() {
    return Row(
      children: [
        _buildStepBadge(0, '1. Chọn máy'),
        _buildStepDivider(0),
        _buildStepBadge(1, '2. Tình trạng'),
        _buildStepDivider(1),
        _buildStepBadge(2, '3. Báo giá'),
      ],
    );
  }

  Widget _buildStepBadge(int stepIndex, String title) {
    final isActive = _currentStep >= stepIndex;
    return Row(
      children: [
        CircleAvatar(
          radius: 12,
          backgroundColor: isActive ? AppColors.primary : Colors.grey[300],
          child: Text(
            '${stepIndex + 1}',
            style: const TextStyle(fontSize: 10, color: Colors.white, fontWeight: FontWeight.bold),
          ),
        ),
        const SizedBox(width: 4),
        Text(
          title,
          style: TextStyle(
            fontSize: 11,
            fontWeight: isActive ? FontWeight.w800 : FontWeight.w500,
            color: isActive ? AppColors.primary : Colors.grey[600],
          ),
        ),
      ],
    );
  }

  Widget _buildStepDivider(int afterStep) {
    final isActive = _currentStep > afterStep;
    return Expanded(
      child: Container(
        height: 2,
        margin: const EdgeInsets.symmetric(horizontal: 6),
        color: isActive ? AppColors.primary : Colors.grey[300],
      ),
    );
  }

  // STEP 1: CHỌN DÒNG MÁY & DUNG LƯỢNG
  Widget _buildStep1DeviceSelection() {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Chọn điện thoại bạn muốn bán',
              style: TextStyle(fontSize: 15, fontWeight: FontWeight.w900),
            ),
            const SizedBox(height: 12),
            DropdownButtonFormField<PhoneModel>(
              initialValue: _selectedModel,
              decoration: const InputDecoration(labelText: 'Dòng máy (Model)'),
              items: _availableModels.map((p) {
                return DropdownMenuItem(value: p, child: Text(p.name));
              }).toList(),
              onChanged: (val) {
                if (val != null) {
                  setState(() {
                    _selectedModel = val;
                    _selectedCapacity = val.capacities.first;
                  });
                }
              },
            ),
            const SizedBox(height: 16),
            const Text('Dung lượng bộ nhớ:', style: TextStyle(fontSize: 13, fontWeight: FontWeight.bold)),
            const SizedBox(height: 8),
            Wrap(
              spacing: 8,
              children: (_selectedModel?.capacities ?? ['128GB', '256GB']).map((cap) {
                final isSel = _selectedCapacity == cap;
                return ChoiceChip(
                  label: Text(cap),
                  selected: isSel,
                  selectedColor: AppColors.primary,
                  onSelected: (_) => setState(() => _selectedCapacity = cap),
                  labelStyle: TextStyle(
                    color: isSel ? Colors.white : AppColors.textPrimary,
                    fontWeight: FontWeight.bold,
                  ),
                );
              }).toList(),
            ),
            const SizedBox(height: 24),
            SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: () => setState(() => _currentStep = 1),
                child: const Text('TIẾP TỤC: ĐÁNH GIÁ TÌNH TRẠNG >'),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // STEP 2: ĐÁNH GIÁ NGOẠI HÌNH & MÀN HÌNH
  Widget _buildStep2HardwareCondition() {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              'Tình trạng: ${_selectedModel?.name} $_selectedCapacity',
              style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w900, color: AppColors.primary),
            ),
            const SizedBox(height: 16),
            const Text('1. Ngoại hình vỏ & viền máy:', style: TextStyle(fontSize: 13, fontWeight: FontWeight.bold)),
            const SizedBox(height: 8),
            _buildConditionTile('grade_a', 'Grade A: Đẹp như mới, không trầy xước', _bodyGrade, (v) => setState(() => _bodyGrade = v)),
            _buildConditionTile('grade_b', 'Grade B: Trầy xước nhẹ, không cấn móp', _bodyGrade, (v) => setState(() => _bodyGrade = v)),
            _buildConditionTile('grade_c', 'Grade C: Cấn móp góc viền hoặc trầy nhiều', _bodyGrade, (v) => setState(() => _bodyGrade = v)),
            
            const SizedBox(height: 16),
            const Text('2. Tình trạng màn hình & cảm ứng:', style: TextStyle(fontSize: 13, fontWeight: FontWeight.bold)),
            const SizedBox(height: 8),
            _buildConditionTile('grade_a', 'Màn hình zin keng, hiển thị sắc nét 100%', _screenGrade, (v) => setState(() => _screenGrade = v)),
            _buildConditionTile('grade_b', 'Màn xước lông mèo nhẹ, không ảnh hưởng hiển thị', _screenGrade, (v) => setState(() => _screenGrade = v)),
            _buildConditionTile('grade_c', 'Màn ám ố nhẹ, phản quang hoặc trầy sâu', _screenGrade, (v) => setState(() => _screenGrade = v)),

            const SizedBox(height: 24),
            Row(
              children: [
                Expanded(
                  child: OutlinedButton(
                    onPressed: () => setState(() => _currentStep = 0),
                    child: const Text('Quay lại'),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  flex: 2,
                  child: ElevatedButton(
                    onPressed: _calculatePrice,
                    child: _isCalculating
                        ? const SizedBox(width: 18, height: 18, child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2))
                        : const Text('XEM BÁO GIÁ NGAY ⚡'),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildConditionTile(String value, String title, String groupVal, Function(String) onSelect) {
    final isSelected = value == groupVal;
    return GestureDetector(
      onTap: () => onSelect(value),
      child: Container(
        margin: const EdgeInsets.only(bottom: 8),
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 10),
        decoration: BoxDecoration(
          color: isSelected ? AppColors.primaryContainer : Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(
            color: isSelected ? AppColors.primary : AppColors.border,
            width: isSelected ? 1.5 : 1,
          ),
        ),
        child: Row(
          children: [
            Icon(
              isSelected ? Icons.radio_button_checked : Icons.radio_button_off,
              color: isSelected ? AppColors.primary : Colors.grey,
              size: 18,
            ),
            const SizedBox(width: 10),
            Expanded(
              child: Text(
                title,
                style: TextStyle(
                  fontSize: 12,
                  fontWeight: isSelected ? FontWeight.w800 : FontWeight.w500,
                  color: isSelected ? AppColors.primaryDark : AppColors.textPrimary,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // STEP 3: KẾT QUẢ ĐỊNH GIÁ & ĐẶT LỊCH THU MUA
  Widget _buildStep3ResultAndBooking() {
    return Column(
      children: [
        // Result Highlight Card
        Container(
          width: double.infinity,
          padding: const EdgeInsets.all(20),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(20),
            border: Border.all(color: AppColors.primary.withValues(alpha: 0.3), width: 1.5),
            boxShadow: [
              BoxShadow(
                color: AppColors.primary.withValues(alpha: 0.08),
                blurRadius: 16,
                offset: const Offset(0, 4),
              ),
            ],
          ),
          child: Column(
            children: [
              const Text('GIÁ THU MUA DỰ KIẾN', style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.grey)),
              const SizedBox(height: 6),
              Text(
                '${_currencyFormat.format(_estimatedPrice)}đ',
                style: const TextStyle(fontSize: 28, fontWeight: FontWeight.w900, color: AppColors.primary),
              ),
              const SizedBox(height: 4),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 3),
                decoration: BoxDecoration(
                  color: AppColors.gradeA.withValues(alpha: 0.12),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Text(
                  _assignedGrade,
                  style: const TextStyle(color: AppColors.gradeA, fontWeight: FontWeight.w800, fontSize: 11),
                ),
              ),
              const Divider(height: 24),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text('Trợ giá thu cũ lên đời:', style: TextStyle(fontSize: 12, color: Colors.grey)),
                  Text('+${_currencyFormat.format(_subsidy)}đ', style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.green)),
                ],
              ),
              const SizedBox(height: 6),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  const Text('Tổng quyền lợi nhận được:', style: TextStyle(fontSize: 13, fontWeight: FontWeight.bold)),
                  Text('${_currencyFormat.format(_estimatedPrice + _subsidy)}đ', style: const TextStyle(fontSize: 15, fontWeight: FontWeight.w900, color: AppColors.primaryDark)),
                ],
              ),
            ],
          ),
        ),

        const SizedBox(height: 16),

        // Quick Booking Form
        Card(
          child: Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text('Đặt Lịch Tiếp Nhận Thiết Bị', style: TextStyle(fontSize: 15, fontWeight: FontWeight.w900)),
                const SizedBox(height: 4),
                const Text('Chọn nhận tiền tại nhà (sau 60p) hoặc ghé 128 Showroom PhoneX.', style: TextStyle(fontSize: 11, color: Colors.grey)),
                const SizedBox(height: 14),
                TextField(
                  controller: _nameController,
                  decoration: const InputDecoration(labelText: 'Họ và tên của bạn *'),
                ),
                const SizedBox(height: 12),
                TextField(
                  controller: _phoneController,
                  keyboardType: TextInputType.phone,
                  decoration: const InputDecoration(labelText: 'Số điện thoại nhận tiền chuyển khoản *'),
                ),
                const SizedBox(height: 12),
                TextField(
                  controller: _addressController,
                  decoration: const InputDecoration(labelText: 'Địa chỉ nhận máy tận nơi (hoặc để trống để đến showroom)'),
                ),
                const SizedBox(height: 18),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                    onPressed: _submitBooking,
                    child: const Text('XÁC NHẬN BÁN MÁY & GIỮ GIÁ 72H'),
                  ),
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildSuccessCard() {
    return Container(
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: Colors.green.withValues(alpha: 0.3)),
      ),
      child: Column(
        children: [
          const Icon(Icons.check_circle, color: Colors.green, size: 64),
          const SizedBox(height: 12),
          const Text('Khởi Tạo Phiếu Thu Thành Công!', style: TextStyle(fontSize: 18, fontWeight: FontWeight.w900)),
          const SizedBox(height: 6),
          const Text('Kỹ thuật viên PhoneX đã tiếp nhận yêu cầu và sẽ liên hệ trong 5 phút.', textAlign: TextAlign.center, style: TextStyle(fontSize: 12, color: Colors.grey)),
          const SizedBox(height: 16),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
            decoration: BoxDecoration(
              color: Colors.grey[100],
              borderRadius: BorderRadius.circular(12),
            ),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                const Text('Mã tra cứu tiến độ:', style: TextStyle(fontSize: 12, fontWeight: FontWeight.w600)),
                Text(_ticketCode, style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w900, color: AppColors.primary)),
              ],
            ),
          ),
          const SizedBox(height: 20),
          ElevatedButton(
            onPressed: () {
              setState(() {
                _currentStep = 0;
                _isSuccess = false;
                _nameController.clear();
                _phoneController.clear();
              });
            },
            child: const Text('Định giá thêm thiết bị khác'),
          ),
        ],
      ),
    );
  }
}
