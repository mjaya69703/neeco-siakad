<div class="settings">
    <a href="#" class="btn btn-floating btn-icon btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSettings" aria-controls="offcanvasSettings" aria-label="Theme Builder">
        <!-- Download SVG icon from http://tabler.io/icons/icon/brush -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
            <path d="M3 21v-4a4 4 0 1 1 4 4h-4" />
            <path d="M21 3a16 16 0 0 0 -12.8 10.2" />
            <path d="M21 3a16 16 0 0 1 -10.2 12.8" />
            <path d="M10.6 9a9 9 0 0 1 4.4 4.4" />
        </svg>
    </a>
    <form class="offcanvas offcanvas-start offcanvas-narrow" tabindex="-1" id="offcanvasSettings">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title">Theme Builder</h2>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <div>
                <div class="mb-4">
                    <label class="form-label">Color mode</label>
                    <p class="form-hint">Choose the color mode for your app.</p>
                    <label class="form-check">
                        <div class="form-selectgroup-item">
                            <input type="radio" name="theme" value="light" class="form-check-input" checked />
                            <div class="form-check-label">Light</div>
                        </div>
                    </label>
                    <label class="form-check">
                        <div class="form-selectgroup-item">
                            <input type="radio" name="theme" value="dark" class="form-check-input" />
                            <div class="form-check-label">Dark</div>
                        </div>
                    </label>
                </div>
                <div class="mb-4">
                    <label class="form-label">Color scheme</label>
                    <p class="form-hint">The perfect color mode for your app.</p>
                    <div class="row g-2">
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="blue" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-blue"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="azure" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-azure"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="indigo" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-indigo"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="purple" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-purple"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="pink" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-pink"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="red" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-red"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="orange" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-orange"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="yellow" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-yellow"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="lime" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-lime"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="green" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-green"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="teal" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-teal"></span>
                            </label>
                        </div>
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio" value="cyan" class="form-colorinput-input" />
                                <span class="form-colorinput-color bg-cyan"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Font family</label>
                    <p class="form-hint">Choose the font family that fits your app.</p>
                    <div>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-font" value="sans-serif" class="form-check-input" checked />
                                <div class="form-check-label">Sans-serif</div>
                            </div>
                        </label>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-font" value="serif" class="form-check-input" />
                                <div class="form-check-label">Serif</div>
                            </div>
                        </label>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-font" value="monospace" class="form-check-input" />
                                <div class="form-check-label">Monospace</div>
                            </div>
                        </label>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-font" value="comic" class="form-check-input" />
                                <div class="form-check-label">Comic</div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Theme base</label>
                    <p class="form-hint">Choose the gray shade for your app.</p>
                    <div>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-base" value="slate" class="form-check-input" />
                                <div class="form-check-label">Slate</div>
                            </div>
                        </label>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-base" value="gray" class="form-check-input" checked />
                                <div class="form-check-label">Gray</div>
                            </div>
                        </label>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-base" value="zinc" class="form-check-input" />
                                <div class="form-check-label">Zinc</div>
                            </div>
                        </label>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-base" value="neutral" class="form-check-input" />
                                <div class="form-check-label">Neutral</div>
                            </div>
                        </label>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-base" value="stone" class="form-check-input" />
                                <div class="form-check-label">Stone</div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Corner Radius</label>
                    <p class="form-hint">Choose the border radius factor for your app.</p>
                    <div>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-radius" value="0" class="form-check-input" />
                                <div class="form-check-label">0</div>
                            </div>
                        </label>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-radius" value="0.5" class="form-check-input" />
                                <div class="form-check-label">0.5</div>
                            </div>
                        </label>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-radius" value="1" class="form-check-input" checked />
                                <div class="form-check-label">1</div>
                            </div>
                        </label>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-radius" value="1.5" class="form-check-input" />
                                <div class="form-check-label">1.5</div>
                            </div>
                        </label>
                        <label class="form-check">
                            <div class="form-selectgroup-item">
                                <input type="radio" name="theme-radius" value="2" class="form-check-input" />
                                <div class="form-check-label">2</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="mt-auto space-y">
                <button type="button" class="btn w-100" id="reset-changes">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/rotate -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                        <path d="M19.95 11a8 8 0 1 0 -.5 4m.5 5v-5h-5" />
                    </svg>
                    Reset changes
                </button>
                <a href="#" class="btn btn-primary w-100" data-bs-dismiss="offcanvas">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/settings -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    </svg>
                    Save settings
                </a>
            </div>
        </div>
    </form>
</div>
