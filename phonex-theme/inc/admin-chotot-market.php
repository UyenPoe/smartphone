<?php
/**
 * PhoneX Chợ Tốt Smartphone Intelligence & Multi-factor Grade Scanner
 *
 * Menu: PhoneX Thu Mua > 🔍 Chợ Tốt & Grade
 *
 * @package PhoneX
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render Chợ Tốt Market Scanner Page in WP-Admin
 */
function phonex_chotot_market_admin_page() {
	$json_file = get_template_directory() . '/data/chotot-used-phones.json';
	$refreshed_msg = '';

	if ( isset( $_GET['refresh'] ) && '1' === $_GET['refresh'] ) {
		$script = dirname( get_template_directory() ) . '/scripts/crawl-chotot-phones.py';
		if ( file_exists( $script ) ) {
			shell_exec( 'python3 ' . escapeshellarg( $script ) . ' > /dev/null 2>&1 &' );
			$refreshed_msg = 'Tiến trình cào & phân tích dữ liệu mới từ Chợ Tốt đã được kích hoạt chạy ngầm. Vui lòng tải lại sau 15-30 giây để xem tin mới nhất!';
		}
	}

	$data = array(
		'metadata' => array(
			'source' => 'https://www.chotot.com/mua-ban-dien-thoai',
			'crawled_at' => '',
			'total_items' => 0,
			'grade_counts' => array(
				'GRADE_A' => 0,
				'GRADE_B' => 0,
				'GRADE_C' => 0,
				'GRADE_D' => 0,
			)
		),
		'phones' => array()
	);

	if ( file_exists( $json_file ) ) {
		$raw = file_get_contents( $json_file );
		$decoded = json_decode( $raw, true );
		if ( ! empty( $decoded ) && is_array( $decoded ) ) {
			$data = $decoded;
		}
	}

	$phones = $data['phones'] ?? array();
	$meta   = $data['metadata'] ?? array();
	$counts = $meta['grade_counts'] ?? array(
		'GRADE_A' => 0,
		'GRADE_B' => 0,
		'GRADE_C' => 0,
		'GRADE_D' => 0,
	);

	// Collect unique brands
	$brands = array();
	foreach ( $phones as $p ) {
		$b = trim( $p['brand'] ?? 'Khác' );
		if ( ! empty( $b ) && ! in_array( $b, $brands, true ) ) {
			$brands[] = $b;
		}
	}
	sort( $brands );
	?>
	<div class="wrap phonex-chotot-wrap" style="max-width: 1400px; margin-top: 20px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
		
		<?php if ( ! empty( $refreshed_msg ) ) : ?>
			<div class="notice notice-info is-dismissible" style="padding: 12px 16px; margin: 0 0 20px 0; border-left-color: #FF001F; font-weight: 600; border-radius: 8px;">
				<p style="margin: 0; font-size: 13px; color: #111827;"><?php echo esc_html( $refreshed_msg ); ?></p>
			</div>
		<?php endif; ?>

		<!-- TOP HEADER -->
		<div style="background: #fff; padding: 24px; border-radius: 16px; border: 1px solid #e5e7eb; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px;">
			<div>
				<div style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 9999px; background: #fff0f2; color: #b7000c; font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; border: 1px solid #ffdad5;">
					<span style="width: 8px; height: 8px; border-radius: 50%; background: #FF001F; display: inline-block;"></span>
					<span>Market Intelligence • PhoneX Grading Engine</span>
				</div>
				<h1 style="margin: 0; font-size: 24px; font-weight: 900; color: #111827; letter-spacing: -0.02em;">
					Thị Trường Chợ Tốt &amp; Báo Cáo Phân Tích Grade
				</h1>
				<p style="margin: 6px 0 0 0; font-size: 13px; color: #6b7280;">
					Dữ liệu cào trực tiếp từ <a href="https://www.chotot.com/mua-ban-dien-thoai" target="_blank" style="color: #FF001F; font-weight: 700; text-decoration: none;">chotot.com/mua-ban-dien-thoai</a>. Mỗi tin đăng đều được phân tích sâu 4 tiêu chuẩn (Vỏ, Màn hình, Pin, Phần cứng) để xác định chuẩn Grade A/B/C/D.
				</p>
			</div>

			<div style="display: flex; align-items: center; gap: 12px;">
				<div style="font-size: 12px; color: #6b7280; text-align: right;">
					Cập nhật lần cuối:<br>
					<strong style="color: #111827; font-weight: 700;"><?php echo esc_html( $meta['crawled_at'] ?: 'Vừa xong' ); ?></strong>
				</div>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=phonex-chotot-market&refresh=1' ) ); ?>" class="button button-primary" style="background: #FF001F; border-color: #FF001F; height: 38px; line-height: 36px; padding: 0 16px; font-weight: 700; border-radius: 10px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(255,0,31,0.25);">
					<span class="dashicons dashicons-update" style="margin-top: 8px;"></span>
					<span>Làm mới bảng dữ liệu</span>
				</a>
			</div>
		</div>

		<!-- 4 KPI CARDS FOR GRADES -->
		<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 24px;">
			<!-- TOTAL -->
			<div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
				<div style="font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase;">Tổng tin đã cào &amp; phân tích</div>
				<div style="font-size: 28px; font-weight: 900; color: #111827; margin: 4px 0;"><?php echo count( $phones ); ?></div>
				<div style="font-size: 12px; color: #9ca3af;">Nguồn Chợ Tốt danh mục Điện Thoại</div>
			</div>

			<!-- GRADE A -->
			<div style="background: #fff; border: 2px solid #10b981; border-radius: 14px; padding: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<span style="font-size: 11px; font-weight: 800; background: #ecfdf5; color: #047857; padding: 2px 8px; border-radius: 6px; border: 1px solid #a7f3d0; text-transform: uppercase;">Grade A</span>
					<span style="font-size: 11px; font-weight: 700; color: #047857;">99% Like New</span>
				</div>
				<div style="font-size: 28px; font-weight: 900; color: #065f46; margin: 6px 0 4px 0;"><?php echo esc_html( $counts['GRADE_A'] ?? 0 ); ?></div>
				<div style="font-size: 12px; color: #059669;">Máy nguyên zin, đẹp xuất sắc, pin >= 85%</div>
			</div>

			<!-- GRADE B -->
			<div style="background: #fff; border: 1px solid #3b82f6; border-radius: 14px; padding: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<span style="font-size: 11px; font-weight: 800; background: #eff6ff; color: #1d4ed8; padding: 2px 8px; border-radius: 6px; border: 1px solid #bfdbfe; text-transform: uppercase;">Grade B</span>
					<span style="font-size: 11px; font-weight: 700; color: #1d4ed8;">95% Very Good</span>
				</div>
				<div style="font-size: 28px; font-weight: 900; color: #1e40af; margin: 6px 0 4px 0;"><?php echo esc_html( $counts['GRADE_B'] ?? 0 ); ?></div>
				<div style="font-size: 12px; color: #2563eb;">Máy zin qua sử dụng, xước dăm nhẹ, pin 80-84%</div>
			</div>

			<!-- GRADE C -->
			<div style="background: #fff; border: 1px solid #f59e0b; border-radius: 14px; padding: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<span style="font-size: 11px; font-weight: 800; background: #fffbeb; color: #b45309; padding: 2px 8px; border-radius: 6px; border: 1px solid #fde68a; text-transform: uppercase;">Grade C</span>
					<span style="font-size: 11px; font-weight: 700; color: #b45309;">90% Good</span>
				</div>
				<div style="font-size: 28px; font-weight: 900; color: #92400e; margin: 6px 0 4px 0;"><?php echo esc_html( $counts['GRADE_C'] ?? 0 ); ?></div>
				<div style="font-size: 12px; color: #d97706;">Cấn móp, trầy xước nhiều, ám nhẹ, pin &lt; 80%</div>
			</div>

			<!-- GRADE D -->
			<div style="background: #fff; border: 1px solid #ef4444; border-radius: 14px; padding: 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<span style="font-size: 11px; font-weight: 800; background: #fef2f2; color: #b91c1c; padding: 2px 8px; border-radius: 6px; border: 1px solid #fecaca; text-transform: uppercase;">Grade D</span>
					<span style="font-size: 11px; font-weight: 700; color: #b91c1c;">Lỗi / Xác máy</span>
				</div>
				<div style="font-size: 28px; font-weight: 900; color: #991b1b; margin: 6px 0 4px 0;"><?php echo esc_html( $counts['GRADE_D'] ?? 0 ); ?></div>
				<div style="font-size: 12px; color: #dc2626;">Bể vỡ, sọc màn, mất FaceID, dính iCloud</div>
			</div>
		</div>

		<!-- CONTROLS: FILTER TABS & SEARCH -->
		<div style="background: #fff; padding: 16px 20px; border-radius: 14px; border: 1px solid #e5e7eb; margin-bottom: 20px; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 14px;">
			<!-- Grade Tabs -->
			<div style="display: flex; flex-wrap: wrap; gap: 8px;" id="chototGradeFilterTabs">
				<button type="button" class="ct-tab-btn active" data-grade="all" style="padding: 6px 14px; border-radius: 8px; border: 1px solid #FF001F; background: #FF001F; color: #fff; font-size: 12px; font-weight: 800; cursor: pointer;">
					Tất cả (<?php echo count( $phones ); ?>)
				</button>
				<button type="button" class="ct-tab-btn" data-grade="GRADE_A" style="padding: 6px 14px; border-radius: 8px; border: 1px solid #e5e7eb; background: #fff; color: #374151; font-size: 12px; font-weight: 700; cursor: pointer;">
					Grade A (<?php echo esc_html( $counts['GRADE_A'] ?? 0 ); ?>)
				</button>
				<button type="button" class="ct-tab-btn" data-grade="GRADE_B" style="padding: 6px 14px; border-radius: 8px; border: 1px solid #e5e7eb; background: #fff; color: #374151; font-size: 12px; font-weight: 700; cursor: pointer;">
					Grade B (<?php echo esc_html( $counts['GRADE_B'] ?? 0 ); ?>)
				</button>
				<button type="button" class="ct-tab-btn" data-grade="GRADE_C" style="padding: 6px 14px; border-radius: 8px; border: 1px solid #e5e7eb; background: #fff; color: #374151; font-size: 12px; font-weight: 700; cursor: pointer;">
					Grade C (<?php echo esc_html( $counts['GRADE_C'] ?? 0 ); ?>)
				</button>
				<button type="button" class="ct-tab-btn" data-grade="GRADE_D" style="padding: 6px 14px; border-radius: 8px; border: 1px solid #e5e7eb; background: #fff; color: #374151; font-size: 12px; font-weight: 700; cursor: pointer;">
					Grade D (<?php echo esc_html( $counts['GRADE_D'] ?? 0 ); ?>)
				</button>
			</div>

			<!-- Filter by Brand & Text Search -->
			<div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
				<select id="chototBrandFilter" style="padding: 6px 12px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 13px; font-weight: 600; color: #374151; height: 36px;">
					<option value="all">Tất cả thương hiệu</option>
					<?php foreach ( $brands as $b ) : ?>
						<option value="<?php echo esc_attr( strtolower( $b ) ); ?>"><?php echo esc_html( $b ); ?></option>
					<?php endforeach; ?>
				</select>

				<input 
					type="text" 
					id="chototSearchInput" 
					placeholder="Tìm dòng máy, tiêu đề, từ khóa..." 
					style="padding: 6px 12px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 13px; min-width: 240px; height: 36px;"
				/>
			</div>
		</div>

		<!-- LISTINGS TABLE / CARDS -->
		<div style="background: #fff; border-radius: 16px; border: 1px solid #e5e7eb; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
			<div style="overflow-x: auto;">
				<table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
					<thead>
						<tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb; color: #4b5563; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">
							<th style="padding: 14px 16px; width: 60px;">Ảnh</th>
							<th style="padding: 14px 16px;">Sản Phẩm Crawl</th>
							<th style="padding: 14px 16px; width: 140px;">Giá Tham Khảo</th>
							<th style="padding: 14px 16px; width: 160px;">Xác Định Grade</th>
							<th style="padding: 14px 16px;">Phân Tích 4 Tiêu Chí (PhoneX Standard)</th>
							<th style="padding: 14px 16px; width: 110px; text-align: center;">Thao Tác</th>
						</tr>
					</thead>
					<tbody id="chototListingsBody">
						<?php if ( ! empty( $phones ) ) : ?>
							<?php foreach ( $phones as $p ) : 
								$factors = $p['grade_factors'] ?? array();
								$grade_class = $p['grade'];
								$brand_lower = strtolower( $p['brand'] ?? '' );
							?>
								<tr 
									class="ct-phone-row" 
									data-grade="<?php echo esc_attr( $grade_class ); ?>"
									data-brand="<?php echo esc_attr( $brand_lower ); ?>"
									data-title="<?php echo esc_attr( strtolower( $p['title'] . ' ' . $p['model'] . ' ' . $p['description'] ) ); ?>"
									style="border-bottom: 1px solid #f3f4f6; transition: background 0.15s;"
								>
									<!-- THUMB -->
									<td style="padding: 14px 16px; vertical-align: top;">
										<?php if ( ! empty( $p['image'] ) ) : ?>
											<a href="<?php echo esc_url( $p['chotot_url'] ); ?>" target="_blank" rel="noopener noreferrer">
												<img 
													src="<?php echo esc_url( $p['image'] ); ?>" 
													alt="<?php echo esc_attr( $p['title'] ); ?>" 
													style="width: 56px; height: 56px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb; display: block;"
													loading="lazy"
												/>
											</a>
										<?php else : ?>
											<div style="width: 56px; height: 56px; border-radius: 8px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #9ca3af;">No img</div>
										<?php endif; ?>
									</td>

									<!-- INFO -->
									<td style="padding: 14px 16px; vertical-align: top;">
										<div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
											<span style="background: #f3f4f6; color: #374151; font-size: 11px; font-weight: 800; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">
												<?php echo esc_html( $p['brand'] ); ?>
											</span>
											<span style="font-size: 11px; color: #c2410c; background: #fff7ed; padding: 2px 6px; border-radius: 4px; font-weight: 700;">
												Nguồn: Chợ Tốt
											</span>
										</div>
										<a href="<?php echo esc_url( $p['chotot_url'] ); ?>" target="_blank" rel="noopener noreferrer" style="font-weight: 700; color: #111827; text-decoration: none; font-size: 14px; line-height: 1.4; display: block;">
											<?php echo esc_html( $p['title'] ); ?>
										</a>
										<div style="font-size: 12px; color: #6b7280; margin-top: 4px;">
											Dòng máy: <strong style="color: #374151;"><?php echo esc_html( $p['model'] ); ?></strong> &bull; Phân loại: <strong style="color: #FF001F;"><?php echo esc_html( $p['grade_short'] ); ?></strong>
										</div>
										<?php if ( ! empty( $p['description'] ) ) : ?>
											<div style="font-size: 11px; color: #9ca3af; margin-top: 6px; max-width: 480px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
												"<?php echo esc_html( $p['description'] ); ?>"
											</div>
										<?php endif; ?>
									</td>

									<!-- PRICE -->
									<td style="padding: 14px 16px; vertical-align: top;">
										<div style="font-size: 15px; font-weight: 900; color: #FF001F;">
											<?php echo esc_html( $p['price_formatted'] ); ?>
										</div>
										<div style="font-size: 11px; color: #6b7280; margin-top: 2px;">
											<?php echo esc_html( $p['condition_declared'] ); ?>
										</div>
									</td>

									<!-- GRADE BADGE & RATIONALE -->
									<td style="padding: 14px 16px; vertical-align: top;">
										<span style="display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 800; padding: 4px 8px; border-radius: 6px; background: <?php echo esc_attr( $p['grade_bg'] ); ?>; color: <?php echo esc_attr( $p['grade_color'] ); ?>; border: 1px solid <?php echo esc_attr( $p['grade_border'] ); ?>; text-transform: uppercase;">
											<?php echo esc_html( $p['grade_short'] ); ?>
											<span style="opacity: 0.8; font-size: 10px;">(<?php echo esc_html( $p['grade_percent'] ); ?>)</span>
										</span>

										<div style="font-size: 11px; color: #4b5563; margin-top: 6px; line-height: 1.35;">
											<strong>Lý do:</strong> <?php echo esc_html( $p['grade_rationale'] ); ?>
										</div>
									</td>

									<!-- 4 CRITERIA DETAILS -->
									<td style="padding: 14px 16px; vertical-align: top;">
										<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px 12px; font-size: 11px;">
											<div>
												<span style="color: #6b7280; font-weight: 600;">Vỏ máy:</span>
												<strong style="color: #111827;"><?php echo esc_html( $factors['body']['status'] ?? 'Bình thường' ); ?></strong>
											</div>
											<div>
												<span style="color: #6b7280; font-weight: 600;">Màn hình:</span>
												<strong style="color: #111827;"><?php echo esc_html( $factors['screen']['status'] ?? 'Zin đẹp' ); ?></strong>
											</div>
											<div>
												<span style="color: #6b7280; font-weight: 600;">Pin:</span>
												<strong style="color: #111827;"><?php echo esc_html( $factors['battery']['status'] ?? 'Tốt' ); ?></strong>
											</div>
											<div>
												<span style="color: #6b7280; font-weight: 600;">Phần cứng:</span>
												<strong style="color: #111827;"><?php echo esc_html( $factors['hardware']['status'] ?? 'Nguyên bản' ); ?></strong>
											</div>
										</div>
									</td>

									<!-- ACTION -->
									<td style="padding: 14px 16px; vertical-align: top; text-align: center;">
										<a href="<?php echo esc_url( $p['chotot_url'] ); ?>" target="_blank" rel="noopener noreferrer" class="button button-small" style="font-size: 11px; font-weight: 700; border-radius: 6px;">
											Xem Chợ Tốt &rarr;
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="6" style="padding: 40px; text-align: center; color: #6b7280;">
									Chưa có dữ liệu tin rao Chợ Tốt. Vui lòng chạy crawler để cập nhật.
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>

		<!-- Client Filter Script -->
		<script>
		document.addEventListener('DOMContentLoaded', function() {
			const rows = document.querySelectorAll('.ct-phone-row');
			const tabs = document.querySelectorAll('.ct-tab-btn');
			const brandFilter = document.getElementById('chototBrandFilter');
			const searchInput = document.getElementById('chototSearchInput');

			let currentGrade = 'all';
			let currentBrand = 'all';
			let currentSearch = '';

			function applyFilters() {
				rows.forEach(function(row) {
					const rGrade = row.dataset.grade;
					const rBrand = row.dataset.brand;
					const rTitle = row.dataset.title || '';

					const matchGrade = (currentGrade === 'all' || rGrade === currentGrade);
					const matchBrand = (currentBrand === 'all' || rBrand === currentBrand);
					const matchSearch = (!currentSearch || rTitle.includes(currentSearch));

					if (matchGrade && matchBrand && matchSearch) {
						row.style.display = '';
					} else {
						row.style.display = 'none';
					}
				});
			}

			// Grade tabs
			tabs.forEach(function(tab) {
				tab.addEventListener('click', function() {
					tabs.forEach(function(t) {
						t.classList.remove('active');
						t.style.background = '#fff';
						t.style.color = '#374151';
						t.style.borderColor = '#e5e7eb';
					});
					this.classList.add('active');
					this.style.background = '#FF001F';
					this.style.color = '#fff';
					this.style.borderColor = '#FF001F';
					currentGrade = this.dataset.grade;
					applyFilters();
				});
			});

			// Brand dropdown
			brandFilter.addEventListener('change', function() {
				currentBrand = this.value;
				applyFilters();
			});

			// Search input
			searchInput.addEventListener('input', function() {
				currentSearch = this.value.toLowerCase().trim();
				applyFilters();
			});
		});
		</script>
	</div>
	<?php
}
