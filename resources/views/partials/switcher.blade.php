
<div class="offcanvas offcanvas-end border-0 data-theme-colors layout-customizer" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="flex-wrap align-items-center bg-primary bg-gradient p-3 offcanvas-header">
        <h5 class="m-0 me-2 text-white" id="offcanvasRightLabel">تخصيص المظهر</h5>
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <p class="mb-0 text-white-50">اختر المظهر الذي يناسبك</p>
    </div>
    <div class="offcanvas-body p-0">
        <div data-simplebar class="h-100">
            <div class="p-4">

                {{-- ===== وضع المظهر: فاتح / داكن / تلقائي ===== --}}
                <h6 class="mb-0 fw-semibold text-uppercase">وضع المظهر</h6>
                <p class="text-muted">اختر وضع العرض</p>

                <div class="row gy-3">
                    <div class="col-4">
                        <div>
                            <input id="layout-light" name="data-bs-theme" type="radio" value="light" class="form-check-input" checked>
                            <label class="form-check-label p-0 avatar-3xl w-100" for="layout-light">
                                <span class="d-flex h-100 ">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-1">
                                            <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light-subtle d-block p-1"></span>
                                            <span class="d-block h-100 bg-primary-subtle m-2"> </span>
                                            <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">فاتح</h5>
                    </div>
                    <div class="col-4">
                       <div class="border">
                            <input id="layout-dark" name="data-bs-theme" type="radio" value="dark" class="form-check-input">
                            <label class="form-check-label p-0 avatar-3xl w-100 bg-dark" for="layout-dark">
                                <span class="d-flex h-100">
                                    <span class="flex-shrink-0">
                                        <span class="bg-white bg-opacity-10 d-flex h-100 flex-column gap-1 p-1">
                                            <span class="d-block p-1 px-2 bg-white bg-opacity-10 rounded mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-white bg-opacity-10 d-block p-1"></span>
                                            <span class="bg-white bg-opacity-10 d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">داكن</h5>
                    </div>
                    <div class="col-4">
                       <div class="border">
                            <input id="automode" name="data-bs-theme" type="radio" value="auto" class="form-check-input">
                            <label class="form-check-label p-0 avatar-3xl w-100" for="automode">
                                <span class="d-flex h-100 ">
                                    <span class="flex-shrink-0">
                                        <span class="bg-light-subtle d-flex h-100 flex-column gap-1 p-1">
                                            <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                            <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span class="d-flex h-100 flex-column">
                                            <span class="bg-light-subtle d-block p-1"></span>
                                            <span class="d-block h-100 bg-primary-subtle m-2"> </span>
                                            <span class="bg-light-subtle d-block p-1 mt-auto"></span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <h5 class="fs-13 text-center mt-2">تلقائي</h5>
                    </div>
                    <!-- end col -->
                </div>

                {{-- ===== اللون الأساسي ===== --}}
                <div id="sidebar-color" class="mb-4">
                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase">اللون الأساسي</h6>
                    <p class="text-muted">اختر لون النظام.</p>
                    <div class="d-flex flex-wrap gap-3 mb-2">
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-01" value="default" checked>
                            <label class="form-check-label avatar-md" for="themeColor-01"></label>
                        </div>
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-02" value="cyan">
                            <label class="form-check-label avatar-md" for="themeColor-02"></label>
                        </div>
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-03" value="green">
                            <label class="form-check-label avatar-md" for="themeColor-03"></label>
                        </div>
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-04" value="blue">
                            <label class="form-check-label avatar-md" for="themeColor-04"></label>
                        </div>
                        <div class="form-check sidebar-setting card-radio">
                            <input class="form-check-input" type="radio" name="data-theme-colors" id="themeColor-05" value="red">
                            <label class="form-check-label avatar-md" for="themeColor-05"></label>
                        </div>
                    </div>
                </div>

                {{-- Reset Button فقط --}}
                <div class="d-flex justify-content-center pt-3 border-top">
                    <button type="button" class="btn btn-light w-100" id="resetBtn">
                        <i class="ri-reset-right-line me-1"></i> إعادة الضبط
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>