$(document).ready(function () {
	loadSelect2Ajax();
});

function loadSelect2Ajax(){
	$('.provinceId').select2({
		placeholder: "Tỉnh/Thành phố",
		allowClear: true,
		ajax: {
			url: $("input#urlGetListProvince").val(),
			type: 'POST',
			dataType: 'json',
			data: function (data) {
				var $this = $(this).closest('.parent_address');
				$this.find('.districtId').val(0).trigger('change');
				$this.find('.wardId').val(0).trigger('change');
				return {
					SearchText: data.term,
				};
			},
			processResults: function (data, params) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.ProvinceName,
							id: item.ProvinceId,
							data: item
						};
					})
				};
			}
		}
	});

	$('.districtId').select2({
		placeholder: "Quận/Huyện",
		allowClear: true,
		ajax: {
			url: $("input#urlGetListDistrict").val(),
			type: 'POST',
			dataType: 'json',
			data: function (data) {
				var $this = $(this).closest('.parent_address');
				$this.find('.wardId').val(0).trigger('change');
				var provinceId = $this.find('.provinceId').val() 
				return {
					SearchText: data.term,
					ProvinceId: provinceId != null ? provinceId: 0
				};
			},
			processResults: function (data, params) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.DistrictName,
							id: item.DistrictId,
							data: item
						};
					})
				};
			}
		}
	});

	$('.wardId').select2({
		placeholder: "Phường/xã",
		allowClear: true,
		ajax: {
			url: $("input#urlGetListWard").val(),
			type: 'POST',
			dataType: 'json',
			data: function (data) {
				var districtId = $(this).closest('.parent_address').find('.districtId').val() 
				return {
					SearchText: data.term,
					DistrictId: districtId != null ? districtId: '0'
				};
			},
			processResults: function (data, params) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.WardName,
							id: item.WardId,
							data: item
						};
					})
				};
			}
		}
	});
}