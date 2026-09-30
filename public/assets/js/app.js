// =====================================================
// NOTIFICATION
// =====================================================

function showMessage(
	type,
	message,
	driver = 'toastr'
) {

	// =========================
	// TOASTR
	// =========================

	if (driver === 'toastr') {

		switch (type) {

			case 'error':
				toastr.error(message);
				break;

			case 'warning':
				toastr.warning(message);
				break;

			case 'info':
				toastr.info(message);
				break;

			default:
				toastr.success(message);
		}

		return;
	}

	// =========================
	// ZEBRA
	// =========================

	if (driver === 'zebra') {

		new $.Zebra_Dialog(
			message,
			{
				type:
					type === 'error'
						? 'error'
						: 'confirmation',
			}
		);

		return;
	}

	// =========================
	// FALLBACK
	// =========================

	alert(message);
}

// =====================================================
// FLASH MESSAGES
// =====================================================

function handleFlashMessages(
	driver
) {

	if (
		!window.flashMessages
		||
		window.flashMessages.length === 0
	) {

		return;
	}

	window.flashMessages.forEach(msg => {

		showMessage(
			msg.type,
			msg.message,
			driver
		);
	});
}

// =====================================================
// BOOTSTRAP VALIDATION
// =====================================================

function initializeBootstrapValidation(
	driver = 'toastr'
) {

	const forms =
		document.querySelectorAll('form');

	Array.from(forms).forEach(form => {

		// =================================================
		// CHECK FOR REQUIRED FIELDS
		// =================================================

		const hasRequiredFields =
			form.querySelector(
				'[required]'
			) !== null;

		// =================================================
		// NO REQUIRED FIELDS
		// =================================================

		if (!hasRequiredFields) {

			return;
		}

		// =================================================
		// ENABLE BOOTSTRAP VALIDATION
		// =================================================
		//
		// Bootstrap validation uses the form's
		// .was-validated state.
		//
		// novalidate prevents the browser's native
		// validation UI from taking over.

		form.classList.add(
			'needs-validation'
		);

		form.setAttribute(
			'novalidate',
			''
		);

		// =================================================
		// SUBMIT
		// =================================================

		form.addEventListener(

			'submit',

			event => {

				if (
					!form.checkValidity()
				) {

					event.preventDefault();

					event.stopPropagation();

					showMessage(
						'error',
						'Please fix the form errors.',
						driver
					);
				}

				form.classList.add(
					'was-validated'
				);
			},

			false
		);
	});
}

// =====================================================
// APPLICATION BOOT
// =====================================================

document.addEventListener(

	'DOMContentLoaded',

	() => {

		const driver =
			window.uiDriver
			|| 'toastr';

		handleFlashMessages(
			driver
		);

		initializeBootstrapValidation(
			driver
		);
	}
);