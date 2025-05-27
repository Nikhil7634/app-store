    <header id="header" class="" data-search-sug-download="1">
      <div class="nav_container">
        <div class="logo">
          <a class="header-logo-wrap" title="APKPure" href="">
            <img
              alt="APKPure"
              src="https://static.apkpure.com/www/static/imgs/logo_new.png"
              srcset="
                https://static.apkpure.com/www/static/imgs/logo_new@2x.png 2x
              "
              height="32"
              width="159"
              class="p_logo"
            />
            <img
              class="m_logo"
              src="https://static.apkpure.com/mobile/static/imgs/logo_v1.png"
              height="24"
              width="100"
              alt="Logo"
            />
          </a>
        </div>
        <div class="shadow" id="shadow" onclick="closeMenu()"></div>
        <div class="nav_new" id="nav_new">
          <div class="item close_item">
            <button type="button" onclick="closeMenu()">
              <i class="icon icon_close"></i>
            </button>
          </div>
          <div
            class="item nav_user_new nav_user_functional"
            id="nav_user_new"
            data-ref="%2F"
          >
            <a
              id="nav_user_a"
              class=""
              title="user icon"
              data-href="login"
              data-click="nextByApkpure('%2F');$$.setCookie('login_download_management_pop', 'close', 9999)"
              href="javascript:void(0)"
            >
              <img
                id="nav_user_img"
                width="35"
                height="35"
                class="nav_user_img"
                alt="APKPure icon"
                data-src="https://static.apkpure.com/www/static/imgs/no_login_v3.png"
                src="https://static.apkpure.com/www/static/imgs/no_login_v3.png"
              />
            </a>

            <template id="nav_action_list" hidden>
              <div class="nav-action-list">
                <a
                  id="nav_action_download_management"
                  class="nav-action nav-action-download-management"
                  href="javascript:void(0)"
                >
                  <span class="nav-action-icon"
                    ><svg class style="">
                      <use
                        xlink:href="/static/assets/svg/user-center.stack-649b028d.svg#icon-user-download"
                      ></use></svg
                  ></span>
                  <span class="nav-action-text one-line"
                    >Download Management</span
                  >
                </a>
                <a
                  id="nav_action_settings"
                  class="nav-action nav-action-settings"
                  href="javascript:void(0)"
                >
                  <span class="nav-action-icon"
                    ><svg class style="">
                      <use
                        xlink:href="/static/assets/svg/user-center.stack-649b028d.svg#icon-user-settings"
                      ></use></svg
                  ></span>
                  <span class="nav-action-text one-line">Settings</span>
                </a>
                <a class="nav-action nav-action-logout" href="/account/logout">
                  <span class="nav-action-icon"
                    ><svg class style="">
                      <use
                        xlink:href="/static/assets/svg/user-center.stack-649b028d.svg#icon-log-out"
                      ></use></svg
                  ></span>
                  <span class="nav-action-text one-line">Logout</span>
                </a>
              </div>
            </template>
            <template id="nav_recommend_update" hidden>
              <div class="nav-recommend-update">
                <div class="nav-recommend-update-title">
                  Recommended Updates
                </div>
              </div>
            </template>
          </div>
          <div class="item nav_home searching-hide">
            <a href="" class="dt_nav_button" title="Home">
              <i class="icon icon_home"></i>
              <span class="dt_menu_text">Home</span>
            </a>
          </div>

          <div class="item searching-hide">
            <a
              title="hot android game apk"
              class="dt_nav_button nav-g"
              href="game"
            >
              <i class="icon icon_game"></i>
              <span class="dt_menu_text">Games</span>
            </a>
          </div>
          <div class="item searching-hide">
            <a
              title="hot android app apk"
              class="dt_nav_button nav-a"
              href="app"
            >
              <i class="icon icon_app"></i>
              <span class="dt_menu_text">Apps</span>
            </a>
          </div>

          <div class="item many searching-hide" id="article_item">
            <span class="nav-article dt_nav_button dt-nav-parent">
              <i class="icon icon_article"></i>
              <span class="dt_menu_text">Articles</span>
            </span>
            <ul class="nav_submenu">
              <li class="nav_submenu-item">
                <div class="menu_list">
                  <div class="menu_body">
                    <ul>
                      <li>
                        <a
                          href="news"
                          class="dt_menu_text"
                          title="Daily Games News Update"
                          >News</a
                        >
                      </li>
                      <li>
                        <a
                          href="reviews"
                          class="dt_menu_text"
                          title="Ratings, Reviews, and Where to Find the Best Apps"
                          >Reviews</a
                        >
                      </li>
                      <li>
                        <a
                          href="howto"
                          class="dt_menu_text"
                          title="Trending Game & App How-To Tutorials, Guides, Tips & Tricks"
                          >How To</a
                        >
                      </li>
                      <li>
                        <a href="topics" class="dt_menu_text" title="Topics"
                          >Topics</a
                        >
                      </li>
                    </ul>
                    <div class="clear"></div>
                  </div>
                </div>
              </li>
            </ul>
          </div>

          <div class="item many searching-hide">
            <span class="nav-p dt_nav_button dt-nav-parent">
              <i class="icon icon_product"></i>
              <span class="dt_menu_text">Products</span>
            </span>
            <ul class="nav_submenu">
              <li class="nav_submenu-item">
                <div class="menu_list">
                  <div class="menu_body">
                    <ul>
                      <li>
                        <a
                          class="dl-ref dt_menu_text"
                          dl-ref="nav"
                          href="apkpure-app.html?icn=aegon&ici=text-nav"
                          title="APKPure App"
                          >APKPure App</a
                        >
                      </li>
                      <li>
                        <a
                          class="dt_menu_text"
                          href="apk-downloader"
                          title="APK Download"
                          >APK Download</a
                        >
                      </li>
                      <li>
                        <a
                          class="dt_menu_text"
                          href="https://windows.apkpure.com/?utm_source=APKPure&utm_medium=nav_product_link"
                          title="Windows APP"
                          rel="noopener"
                          target="_blank"
                          >Windows APP</a
                        >
                      </li>
                      <li>
                        <a
                          class="dt_menu_text"
                          href="https://iphone.apkpure.com/?utm_source=APKPure&utm_medium=nav_product_link"
                          title="iPhone APP"
                          rel="noopener"
                          target="_blank"
                          >iPhone APP</a
                        >
                      </li>

                      <li>
                        <a
                          class="dt_menu_text"
                          href="https://store.apkpure.com?utm_source=topMenu&amp;utm_medium=APKPure&amp;utm_campaign=click"
                          title="Game Store"
                          rel="noopener"
                          target="_blank"
                          >Game Store</a
                        >
                      </li>
                      <li>
                        <a
                          class="dt_menu_text"
                          href="pre-register"
                          title="Pre-register"
                          >Pre-register</a
                        >
                      </li>
                      <li>
                        <a
                          class="dt_menu_text"
                          href="apk-downloader-browser-extension"
                          title="Chrome Extension"
                          >Chrome Extension</a
                        >
                      </li>
                      <li>
                        <a
                          title="dt_menu_text"
                          href="https://tvonic.apkpure.com/?utm_source=topmenu&utm_medium=APKPure&utm_campaign=click"
                          title="TVOnic"
                          rel="noopener"
                          target="_blank"
                          >TVOnic</a
                        >
                      </li>
                    </ul>
                    <div class="clear"></div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="item nav_aipure searching-hide">
            <a
              class="dt_nav_button"
              title="AIPURE"
              rel="noopener"
              target="_blank"
              href="https://aipure.ai/?utm_source=APKPure&utm_medium=nav_product_link"
            >
              <i class="icon icon_aipure"></i>
              <span class="dt_menu_text">AIPURE</span>
            </a>
          </div>
          <div class="item search">
            <form
              class="formsearch searching-show"
              method="get"
              action="search"
              onsubmit="onSearchSubmit(event)"
            >
              <div class="search-input">
                <input
                  id="form_query"
                  class="query autocomplete main-autocomplete"
                  autocomplete="off"
                  title="Enter App Name, Package Name, Package ID"
                  name="q"
                  type="text"
                  size="40"
                  placeholder="APKPure"
                />
                <input class="search-btn-icon" type="submit" value="" />
                <i class="clear-input"></i>
              </div>

              <div class="search-history">
                <div class="search-history-title">
                  <span>Search history</span>
                  <span class="search-history-delete"
                    ><i class="search-icon-remove"></i
                  ></span>
                </div>
                <div>
                  <ul class="search-history-list" data-path="search"></ul>
                </div>
              </div>
            </form>

            <div class="search-mask">
              <i class="search-mask-icon"></i>
              <span>APKPure</span>
            </div>
          </div>
          <div class="menu-divider"></div>
          <div class="menu-item item grou menu-item-pwa" style="display: none">
            <div>
              <div class="menu-layer">
                <span class="menu-icon-pwa"></span>
                <span class="menu-text">Add to Home Screen</span>
              </div>
            </div>
          </div>
          <div
            id="menu_nav_logout"
            class="item nav_logout"
            style="display: none"
          >
            <a class="dt_nav_button" href="/account/logout" title="Logout">
              <svg class="svg-icon" style="">
                <use
                  xlink:href="/static/assets/svg/user-center.stack-649b028d.svg#icon-log-out"
                ></use>
              </svg>
              <span class="dt_menu_text">Logout</span>
            </a>
          </div>
        </div>
        <button
          id="menu_btn"
          type="button"
          class="menu_btn"
          onclick="openMenu()"
        >
          <i class="icon icon_menu"></i>
        </button>
        <a class="search_btn" title="search" href="search">
          <i class="icon icon_search"></i>
        </a>
      </div>
    </header>