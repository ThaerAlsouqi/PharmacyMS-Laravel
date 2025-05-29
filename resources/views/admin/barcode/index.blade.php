@extends('admin.layouts.app')

@push('page-css')
<style>
	.management-card {
		background: white;
		border-radius: 15px;
		box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
		border: none;
		margin-bottom: 30px;
	}

	.management-header {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: white;
		padding: 20px 25px;
		border-radius: 15px 15px 0 0;
	}

	.management-body {
		padding: 30px;
	}

	.stats-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
		gap: 20px;
		margin-bottom: 30px;
	}

	.stat-card {
		background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
		border: 1px solid rgba(102, 126, 234, 0.2);
		border-radius: 12px;
		padding: 20px;
		text-align: center;
	}

	.stat-number {
		font-size: 2rem;
		font-weight: 700;
		color: #667eea;
		display: block;
	}

	.stat-label {
		color: #6c757d;
		font-size: 0.9rem;
		margin-top: 5px;
	}

	.action-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
		gap: 20px;
		margin-bottom: 30px;
	}

	.action-card {
		background: #fafbfc;
		border: 1px solid #f0f0f0;
		border-radius: 12px;
		padding: 25px;
	}

	.action-title {
		font-weight: 600;
		color: #333;
		margin-bottom: 10px;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.action-description {
		color: #6c757d;
		font-size: 14px;
		margin-bottom: 20px;
		line-height: 1.5;
	}

	.action-btn {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: white;
		border: none;
		border-radius: 8px;
		padding: 12px 20px;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.3s ease;
		width: 100%;
	}

	.action-btn:hover {
		transform: translateY(-2px);
		box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
		color: white;
	}

	.action-btn:disabled {
		opacity: 0.6;
		cursor: not-allowed;
		transform: none;
	}

	.success-btn {
		background: linear-gradient(135deg, #28c76f 0%, #48da89 100%);
	}

	.success-btn:hover {
		box-shadow: 0 5px 15px rgba(40, 199, 111, 0.3);
	}

	.warning-btn {
		background: linear-gradient(135deg, #ff9f43 0%, #ffc107 100%);
	}

	.result-section {
		background: white;
		border: 1px solid #f0f0f0;
		border-radius: 12px;
		padding: 20px;
		margin-top: 20px;
		display: none;
	}

	.result-success {
		border-left: 4px solid #28c76f;
		background: rgba(40, 199, 111, 0.05);
	}

	.result-error {
		border-left: 4px solid #ea5455;
		background: rgba(234, 84, 85, 0.05);
	}

	.loading {
		display: none;
		text-align: center;
		padding: 20px;
		color: #667eea;
	}

	.loading i {
		font-size: 2rem;
		animation: spin 1s linear infinite;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
</style>
@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Barcode Management</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Barcode Management</li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-12">
		<!-- Statistics -->
		<div class="management-card">
			<div class="management-header">
				<h4 style="margin: 0; font-weight: 600;">
					<i class="fas fa-chart-bar mr-2"></i>
					Barcode System Statistics
				</h4>
			</div>
			<div class="management-body">
				<div class="stats-grid">
					<div class="stat-card">
						<span class="stat-number">{{$stats['total_products'] ?? 0}}</span>
						<div class="stat-label">Total Products</div>
					</div>
					<div class="stat-card">
						<span class="stat-number">{{$stats['products_with_barcodes'] ?? 0}}</span>
						<div class="stat-label">Products with Barcodes</div>
					</div>
					<div class="stat-card">
						<span class="stat-number">{{$stats['products_with_qr'] ?? 0}}</span>
						<div class="stat-label">Products with QR Codes</div>
					</div>
					<div class="stat-card">
						<span class="stat-number">{{$stats['total_scans'] ?? 0}}</span>
						<div class="stat-label">Total Scans</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Actions -->
		<div class="management-card">
			<div class="management-header">
				<h4 style="margin: 0; font-weight: 600;">
					<i class="fas fa-cogs mr-2"></i>
					Barcode Generation Tools
				</h4>
			</div>
			<div class="management-body">
				<div class="action-grid">
					<!-- Generate All Barcodes -->
					<div class="action-card">
						<div class="action-title">
							<i class="fas fa-barcode" style="color: #667eea;"></i>
							Generate Product Barcodes
						</div>
						<div class="action-description">
							Create unique barcodes for all products that don't have them yet. 
							Format: PHM + Product ID + Random numbers.
						</div>
						<button class="action-btn" onclick="generateAllBarcodes()">
							<i class="fas fa-magic mr-2"></i>Generate All Barcodes
						</button>
					</div>

					<!-- Generate All QR Codes -->
					<div class="action-card">
						<div class="action-title">
							<i class="fas fa-qrcode" style="color: #28c76f;"></i>
							Generate Product QR Codes
						</div>
						<div class="action-description">
							Create QR codes containing product information for quick scanning and verification.
						</div>
						<button class="success-btn action-btn" onclick="generateAllQRCodes()">
							<i class="fas fa-qrcode mr-2"></i>Generate All QR Codes
						</button>
					</div>

					<!-- Test Scanner -->
					<div class="action-card">
						<div class="action-title">
							<i class="fas fa-search" style="color: #ff9f43;"></i>
							Test Barcode Scanner
						</div>
						<div class="action-description">
							Test the barcode scanning system with a sample code to verify everything is working.
						</div>
						<button class="warning-btn action-btn" onclick="testScanner()">
							<i class="fas fa-play mr-2"></i>Test Scanner
						</button>
					</div>

					<!-- Print Barcodes -->
					<div class="action-card">
						<div class="action-title">
							<i class="fas fa-print" style="color: #764ba2;"></i>
							Print Barcode Labels
						</div>
						<div class="action-description">
							Generate printable barcode labels for all products to stick on your inventory.
						</div>
						<a href="{{route('barcode.print')}}" class="action-btn" style="text-decoration: none; display: block; text-align: center;">
							<i class="fas fa-print mr-2"></i>Print Labels
						</a>
					</div>
				</div>

				<!-- Loading -->
				<div class="loading" id="loading">
					<i class="fas fa-spinner"></i>
					<p>Processing...</p>
				</div>

				<!-- Results -->
				<div class="result-section" id="results"></div>
			</div>
		</div>

		<!-- Recent Scans -->
		@if(isset($recentScans) && $recentScans->count() > 0)
		<div class="management-card">
			<div class="management-header">
				<h4 style="margin: 0; font-weight: 600;">
					<i class="fas fa-history mr-2"></i>
					Recent Scans
				</h4>
			</div>
			<div class="management-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Product</th>
								<th>Barcode</th>
								<th>Scanned By</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							@foreach($recentScans as $scan)
							<tr>
								<td>
									<strong>{{$scan->product->purchase->product ?? 'Unknown'}}</strong>
								</td>
								<td>
									<code style="background: #f8f9fc; padding: 4px 8px; border-radius: 4px;">
										{{$scan->barcode}}
									</code>
								</td>
								<td>{{$scan->user->name ?? 'System'}}</td>
								<td>{{$scan->scanned_at->format('M d, Y H:i')}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
@endsection

@push('page-js')
<script>
// Generate all barcodes
function generateAllBarcodes() {
	showLoading();
	
	fetch('/admin/barcode/generate-all', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': '{{csrf_token()}}'
		}
	})
	.then(response => response.json())
	.then(data => {
		hideLoading();
		
		if (data.success) {
			showResult(`
				<h5 style="color: #28c76f;">✅ Barcodes Generated Successfully!</h5>
				<p><strong>Generated:</strong> ${data.generated} new barcodes</p>
				<p><strong>Total Products:</strong> ${data.total_products}</p>
				${data.errors.length > 0 ? '<p><strong>Errors:</strong> ' + data.errors.join(', ') + '</p>' : ''}
			`, 'success');
			
			// Refresh page after 3 seconds
			setTimeout(() => {
				window.location.reload();
			}, 3000);
		} else {
			showResult(`
				<h5 style="color: #ea5455;">❌ Generation Failed</h5>
				<p>${data.message}</p>
			`, 'error');
		}
	})
	.catch(error => {
		hideLoading();
		showResult(`
			<h5 style="color: #ea5455;">❌ Error</h5>
			<p>Failed to generate barcodes. Please try again.</p>
		`, 'error');
	});
}

// Generate all QR codes
function generateAllQRCodes() {
	showLoading();
	
	fetch('/admin/qrcode/generate-all', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': '{{csrf_token()}}'
		}
	})
	.then(response => response.json())
	.then(data => {
		hideLoading();
		
		if (data.success) {
			showResult(`
				<h5 style="color: #28c76f;">✅ QR Codes Generated Successfully!</h5>
				<p><strong>Generated:</strong> ${data.generated} new QR codes</p>
				<p>${data.message}</p>
			`, 'success');
			
			setTimeout(() => {
				window.location.reload();
			}, 3000);
		} else {
			showResult(`
				<h5 style="color: #ea5455;">❌ QR Generation Failed</h5>
				<p>${data.message}</p>
			`, 'error');
		}
	})
	.catch(error => {
		hideLoading();
		showResult(`
			<h5 style="color: #ea5455;">❌ Error</h5>
			<p>Failed to generate QR codes. Please try again.</p>
		`, 'error');
	});
}

// Test scanner
function testScanner() {
	showLoading();
	
	// Test with a sample barcode
	const testCode = 'PHM000112345';
	
	fetch('/admin/barcode/scan', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': '{{csrf_token()}}'
		},
		body: JSON.stringify({
			code: testCode
		})
	})
	.then(response => response.json())
	.then(data => {
		hideLoading();
		
		if (data.success) {
			showResult(`
				<h5 style="color: #28c76f;">✅ Scanner Working!</h5>
				<p><strong>Test Code:</strong> ${testCode}</p>
				<p><strong>Found:</strong> ${data.data.name}</p>
				<p><strong>Price:</strong> $${data.data.price}</p>
			`, 'success');
		} else {
			showResult(`
				<h5 style="color: #ff9f43;">⚠️ Scanner Test Result</h5>
				<p><strong>Test Code:</strong> ${testCode}</p>
				<p><strong>Result:</strong> ${data.message}</p>
				<p>This is normal if you haven't generated barcodes yet.</p>
			`, 'warning');
		}
	})
	.catch(error => {
		hideLoading();
		showResult(`
			<h5 style="color: #ea5455;">❌ Scanner Error</h5>
			<p>Scanner test failed. Check system configuration.</p>
		`, 'error');
	});
}

// Show loading
function showLoading() {
	document.getElementById('loading').style.display = 'block';
	document.getElementById('results').style.display = 'none';
	
	// Disable all buttons
	document.querySelectorAll('.action-btn').forEach(btn => {
		btn.disabled = true;
	});
}

// Hide loading
function hideLoading() {
	document.getElementById('loading').style.display = 'none';
	
	// Enable all buttons
	document.querySelectorAll('.action-btn').forEach(btn => {
		btn.disabled = false;
	});
}

// Show result
function showResult(html, type) {
	const results = document.getElementById('results');
	results.innerHTML = html;
	results.className = `result-section result-${type}`;
	results.style.display = 'block';
}
</script>
@endpush