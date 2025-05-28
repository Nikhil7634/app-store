<?php include "includes/header.php" ?>
<?php include "includes/navbar.php" ?>
<?php
// Include the config.php for database connection
require_once 'includes/config.php';

// Fetch all categories
try {
    $categories_query = "SELECT id, category_name FROM categories ORDER BY category_name";
    $categories_stmt = $dbh->prepare($categories_query);
    $categories_stmt->execute();
    $categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    exit("Error fetching categories: " . $e->getMessage());
}

 // Fetch all blog posts
try {
    // Fetch all blog posts
    $blogs_query = "
        SELECT id, title, image_path, updated_at, slug
        FROM blogs
        ORDER BY updated_at DESC
    ";
    // Option: Fetch blog posts from the last 24 hours (uncomment to enable)
    /*
    $blogs_query = "
        SELECT id, title, image_path, updated_at, slug
        FROM blogs
        WHERE updated_at >= NOW() - INTERVAL 24 HOUR
        ORDER BY updated_at DESC
    ";
    */
    $blogs_stmt = $dbh->prepare($blogs_query);
    $blogs_stmt->execute();
    $blogs = $blogs_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit("Error fetching blogs: " . $e->getMessage());
}
?>

    <div class="main-body">
      <div class="left">
        <div id="top-slide-banner" class="slide-banner">
          <div class="container">
            <div class="list">
              <a
                title="Block Blast! APK"
                class="banner-item"
                href="block-blast/com.block.juggle"
                data-dt-app="com.block.juggle"
                data-dt-recid=""
                ><img
                  class="banner-bg"
                  alt="Block Blast!"
                  src="https://image.winudf.com/v2/image1/Y29tLmJsb2NrLmp1Z2dsZV9iYW5uZXJfMTc0MzcwMzk1MV8wMzg/banner.webp?w=360&amp;fakeurl=1&amp;type=.webp"
                  srcset="
                    https://image.winudf.com/v2/image1/Y29tLmJsb2NrLmp1Z2dsZV9iYW5uZXJfMTc0MzcwMzk1MV8wMzg/banner.webp?w=720&amp;fakeurl=1&amp;type=.webp   720w,
                    https://image.winudf.com/v2/image1/Y29tLmJsb2NrLmp1Z2dsZV9iYW5uZXJfMTc0MzcwMzk1MV8wMzg/banner.webp?w=1080&amp;fakeurl=1&amp;type=.webp 1080w,
                    https://image.winudf.com/v2/image1/Y29tLmJsb2NrLmp1Z2dsZV9iYW5uZXJfMTc0MzcwMzk1MV8wMzg/banner.webp?w=1736&amp;fakeurl=1&amp;type=.webp 1736w
                  "
                  sizes="(max-width: 996px) 100vw, 868px"
                  width="360"
                  height="170"
                />
                <div class="mask"></div>
                <div class="info">
                  <img
                    class="icon lazy"
                    alt="Block Blast!"
                    src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                    data-original="https://image.winudf.com/v2/image1/Y29tLmJsb2NrLmp1Z2dsZV9pY29uXzE2NjkwMTU4OTZfMDM5/icon.webp?w=48&amp;fakeurl=1&amp;type=.webp"
                    data-srcset="https://image.winudf.com/v2/image1/Y29tLmJsb2NrLmp1Z2dsZV9pY29uXzE2NjkwMTU4OTZfMDM5/icon.webp?w=96&amp;fakeurl=1&amp;type=.webp 2x"
                    width="32"
                    height="32"
                  />
                  <div class="name">Block Blast!</div>
                  <div
                    class="button"
                    apkpure-click-go="block-blast/com.block.juggle/download"
                  >
                    Download
                  </div>
                </div> </a
              ><a
                title="Honkai: Star Rail APK"
                class="banner-item"
                href="honkai-star-rail/com.HoYoverse.hkrpgoversea"
                data-dt-app="com.HoYoverse.hkrpgoversea"
                data-dt-recid=""
                ><img
                  class="banner-bg lazy"
                  alt="Honkai: Star Rail"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/Y29tLkhvWW92ZXJzZS5oa3JwZ292ZXJzZWFfYmFubmVyXzE2NzU5NTc1NjFfMDM0/banner.webp?w=360&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/Y29tLkhvWW92ZXJzZS5oa3JwZ292ZXJzZWFfYmFubmVyXzE2NzU5NTc1NjFfMDM0/banner.webp?w=720&amp;fakeurl=1&amp;type=.webp 720w, https://image.winudf.com/v2/image1/Y29tLkhvWW92ZXJzZS5oa3JwZ292ZXJzZWFfYmFubmVyXzE2NzU5NTc1NjFfMDM0/banner.webp?w=1080&amp;fakeurl=1&amp;type=.webp 1080w, https://image.winudf.com/v2/image1/Y29tLkhvWW92ZXJzZS5oa3JwZ292ZXJzZWFfYmFubmVyXzE2NzU5NTc1NjFfMDM0/banner.webp?w=1736&amp;fakeurl=1&amp;type=.webp 1736w"
                  sizes="(max-width: 996px) 100vw, 868px"
                  width="360"
                  height="170"
                />
                <div class="mask"></div>
                <div class="info">
                  <img
                    class="icon lazy"
                    alt="Honkai: Star Rail"
                    src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                    data-original="https://image.winudf.com/v2/image1/Y29tLkhvWW92ZXJzZS5oa3JwZ292ZXJzZWFfaWNvbl8xNzQ3Nzg0MjQ5XzAyMg/icon.webp?w=48&amp;fakeurl=1&amp;type=.webp"
                    data-srcset="https://image.winudf.com/v2/image1/Y29tLkhvWW92ZXJzZS5oa3JwZ292ZXJzZWFfaWNvbl8xNzQ3Nzg0MjQ5XzAyMg/icon.webp?w=96&amp;fakeurl=1&amp;type=.webp 2x"
                    width="32"
                    height="32"
                  />
                  <div class="name">Honkai: Star Rail</div>
                  <div
                    class="button"
                    apkpure-click-go="honkai-star-rail/com.HoYoverse.hkrpgoversea/download"
                  >
                    Download
                  </div>
                </div> </a
              ><a
                title="AI Video Editor: ShotCut AI APK"
                class="banner-item"
                href="shotcut-video-editor-pro/video.editor.videomaker.effects.fx"
                data-dt-app="video.editor.videomaker.effects.fx"
                data-dt-recid=""
                ><img
                  class="banner-bg lazy"
                  alt="AI Video Editor: ShotCut AI"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/dmlkZW8uZWRpdG9yLnZpZGVvbWFrZXIuZWZmZWN0cy5meF9iYW5uZXJfMTcxOTkyMDI0NF8wNzY/banner.webp?w=360&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/dmlkZW8uZWRpdG9yLnZpZGVvbWFrZXIuZWZmZWN0cy5meF9iYW5uZXJfMTcxOTkyMDI0NF8wNzY/banner.webp?w=720&amp;fakeurl=1&amp;type=.webp 720w, https://image.winudf.com/v2/image1/dmlkZW8uZWRpdG9yLnZpZGVvbWFrZXIuZWZmZWN0cy5meF9iYW5uZXJfMTcxOTkyMDI0NF8wNzY/banner.webp?w=1080&amp;fakeurl=1&amp;type=.webp 1080w, https://image.winudf.com/v2/image1/dmlkZW8uZWRpdG9yLnZpZGVvbWFrZXIuZWZmZWN0cy5meF9iYW5uZXJfMTcxOTkyMDI0NF8wNzY/banner.webp?w=1736&amp;fakeurl=1&amp;type=.webp 1736w"
                  sizes="(max-width: 996px) 100vw, 868px"
                  width="360"
                  height="170"
                />
                <div class="mask"></div>
                <div class="info">
                  <img
                    class="icon lazy"
                    alt="AI Video Editor: ShotCut AI"
                    src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                    data-original="https://image.winudf.com/v2/image1/dmlkZW8uZWRpdG9yLnZpZGVvbWFrZXIuZWZmZWN0cy5meF9pY29uXzE3Mzg3Nzg4NTNfMDk3/icon.webp?w=48&amp;fakeurl=1&amp;type=.webp"
                    data-srcset="https://image.winudf.com/v2/image1/dmlkZW8uZWRpdG9yLnZpZGVvbWFrZXIuZWZmZWN0cy5meF9pY29uXzE3Mzg3Nzg4NTNfMDk3/icon.webp?w=96&amp;fakeurl=1&amp;type=.webp 2x"
                    width="32"
                    height="32"
                  />
                  <div class="name">AI Video Editor: ShotCut AI</div>
                  <div
                    class="button"
                    apkpure-click-go="shotcut-video-editor-pro/video.editor.videomaker.effects.fx/download"
                  >
                    Download
                  </div>
                </div> </a
              ><a
                title="Free Fire: 8th Anniversary! APK"
                class="banner-item"
                href="garena-free-fire-android-2024/com.dts.freefireth"
                data-dt-app="com.dts.freefireth"
                data-dt-recid=""
                ><img
                  class="banner-bg lazy"
                  alt="Free Fire: 8th Anniversary!"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/Y29tLmR0cy5mcmVlZmlyZXRoX2Jhbm5lcl8xNzE2ODY3MzA4XzA1OQ/banner.webp?w=360&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/Y29tLmR0cy5mcmVlZmlyZXRoX2Jhbm5lcl8xNzE2ODY3MzA4XzA1OQ/banner.webp?w=720&amp;fakeurl=1&amp;type=.webp 720w, https://image.winudf.com/v2/image1/Y29tLmR0cy5mcmVlZmlyZXRoX2Jhbm5lcl8xNzE2ODY3MzA4XzA1OQ/banner.webp?w=1080&amp;fakeurl=1&amp;type=.webp 1080w, https://image.winudf.com/v2/image1/Y29tLmR0cy5mcmVlZmlyZXRoX2Jhbm5lcl8xNzE2ODY3MzA4XzA1OQ/banner.webp?w=1736&amp;fakeurl=1&amp;type=.webp 1736w"
                  sizes="(max-width: 996px) 100vw, 868px"
                  width="360"
                  height="170"
                />
                <div class="mask"></div>
                <div class="info">
                  <img
                    class="icon lazy"
                    alt="Free Fire: 8th Anniversary!"
                    src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                    data-original="https://image.winudf.com/v2/image1/Y29tLmR0cy5mcmVlZmlyZXRoX2ljb25fMTc0NzgwMzQ2NV8wNjA/icon.webp?w=48&amp;fakeurl=1&amp;type=.webp"
                    data-srcset="https://image.winudf.com/v2/image1/Y29tLmR0cy5mcmVlZmlyZXRoX2ljb25fMTc0NzgwMzQ2NV8wNjA/icon.webp?w=96&amp;fakeurl=1&amp;type=.webp 2x"
                    width="32"
                    height="32"
                  />
                  <div class="name">Free Fire: 8th Anniversary!</div>
                  <div
                    class="button"
                    apkpure-click-go="garena-free-fire-android-2024/com.dts.freefireth/download"
                  >
                    Download
                  </div>
                </div>
              </a>
            </div>
          </div>
          <ul class="dots"></ul>
          <div class="prev"></div>
          <div class="next"></div>
        </div>







        <div class="module no-scrollbar quick-access-new">
          <a title="Games" href="/game" data-dt-name="games" class=""
            ><i class="icon"
              ><svg
                width="56"
                height="56"
                viewBox="0 0 56 56"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <g id="&#231;&#177;&#187;&#229;&#158;&#139;=Games">
                  <path
                    id="&#230;&#164;&#173;&#229;&#156;&#134;"
                    d="M56 28C56 47.33 47.33 56 28 56C8.67003 56 0 47.33 0 28C0 8.67003 8.67003 0 28 0C47.33 0 56 8.67003 56 28Z"
                    fill="url(#paint0_linear_19_8275)"
                  />
                  <g id="Vector" filter="url(#filter0_d_19_8275)">
                    <path
                      d="M42.7811 20.2449C38.0256 12.3815 30.8616 17.8518 30.8616 17.8518C30.3972 18.2049 29.5404 18.4964 28.9572 18.4981H27.042C26.4588 18.4981 25.602 18.2084 25.1394 17.8552C25.1394 17.8552 17.9755 12.3849 13.2199 20.2467C8.46614 28.1067 10.3813 36.6661 10.3813 36.6661C10.7161 38.7627 11.8231 40.1616 13.9111 39.985C15.9937 39.8119 20.5117 34.3433 20.5117 34.3433C20.8843 33.8924 21.6673 33.5238 22.2469 33.5238L33.7488 33.5221C34.3302 33.5221 35.1132 33.8907 35.4858 34.3416C35.4858 34.3416 40.0037 39.8101 42.0899 39.985C44.1743 40.1616 45.2831 38.761 45.6179 36.6661C45.6179 36.6661 47.5349 28.1084 42.7811 20.2467V20.2449ZM23.6778 26.6444H21.2119V29.0375C21.2119 29.0375 20.6899 29.4387 19.8799 29.4284C19.0735 29.4164 18.7099 28.9913 18.7099 28.9913V26.6461H16.3771C16.3771 26.6461 16.0855 26.3461 16.0081 25.5558C15.9325 24.7655 16.3303 24.1278 16.3303 24.1278H18.7963V21.6455C18.7963 21.6455 19.3039 21.3712 20.0347 21.3918C20.7655 21.4158 21.3001 21.6918 21.3001 21.6918L21.2893 24.1261H23.6184C23.6184 24.1261 24.0252 24.6524 24.0594 25.2867C24.0936 25.9227 23.676 26.6444 23.676 26.6444H23.6778ZM34.9908 29.3701C33.9108 29.3701 33.0396 28.4924 33.0396 27.4072C33.0396 26.3187 33.9108 25.4427 34.9908 25.4427C36.0654 25.4427 36.9438 26.3187 36.9438 27.4072C36.9438 28.4924 36.0654 29.3718 34.9908 29.3718V29.3701ZM34.9908 23.9649C33.9108 23.9649 33.0396 23.0872 33.0396 22.0021C33.0396 20.9135 33.9108 20.0358 34.9908 20.0358C36.0654 20.0358 36.9438 20.9135 36.9438 22.0021C36.9438 23.0872 36.0654 23.9649 34.9908 23.9649ZM39.8508 26.8672C38.7708 26.8672 37.9014 25.9895 37.9014 24.9027C37.9014 23.8158 38.7726 22.9381 39.8526 22.9381C40.9271 22.9381 41.8055 23.8158 41.8055 24.9027C41.8055 25.9895 40.9271 26.8672 39.8526 26.8672H39.8508Z"
                      fill="#FFEFDC"
                    />
                  </g>
                </g>
                <defs>
                  <filter
                    id="filter0_d_19_8275"
                    x="10"
                    y="16"
                    width="37.5"
                    height="25.5"
                    filterUnits="userSpaceOnUse"
                    color-interpolation-filters="sRGB"
                  >
                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                    <feColorMatrix
                      in="SourceAlpha"
                      type="matrix"
                      values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                      result="hardAlpha"
                    />
                    <feOffset dx="1.5" dy="1.5" />
                    <feComposite in2="hardAlpha" operator="out" />
                    <feColorMatrix
                      type="matrix"
                      values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"
                    />
                    <feBlend
                      mode="normal"
                      in2="BackgroundImageFix"
                      result="effect1_dropShadow_19_8275"
                    />
                    <feBlend
                      mode="normal"
                      in="SourceGraphic"
                      in2="effect1_dropShadow_19_8275"
                      result="shape"
                    />
                  </filter>
                  <linearGradient
                    id="paint0_linear_19_8275"
                    x1="0"
                    y1="0"
                    x2="50.8755"
                    y2="60.322"
                    gradientUnits="userSpaceOnUse"
                  >
                    <stop offset="0.125" stop-color="#F4B512" />
                    <stop offset="1" stop-color="#FF6E57" />
                  </linearGradient>
                </defs>
              </svg>
            </i>
            <p>Games</p> </a
          ><a title="Apps" href="/app" data-dt-name="apps" class=""
            ><i class="icon"
              ><svg
                width="56"
                height="56"
                viewBox="0 0 56 56"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <g id="&#231;&#177;&#187;&#229;&#158;&#139;=Apps">
                  <path
                    id="&#230;&#164;&#173;&#229;&#156;&#134;"
                    d="M56 28C56 47.33 47.33 56 28 56C8.67003 56 0 47.33 0 28C0 8.67003 8.67003 0 28 0C47.33 0 56 8.67003 56 28Z"
                    fill="url(#paint0_linear_19_10232)"
                  />
                  <g id="Vector" filter="url(#filter0_d_19_10232)">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M37.9022 18.9617C41.616 21.8962 44 26.4441 44 31.5497H12C12 26.444 14.3841 21.8961 18.098 18.9615L15.5146 16.3741C15.0464 15.9051 15.0464 15.1447 15.5146 14.6757C15.9829 14.2067 16.7421 14.2067 17.2104 14.6757L20.1264 17.5963C22.451 16.2777 25.1377 15.5249 28 15.5249C30.8624 15.5249 33.5492 16.2777 35.8738 17.5964L39.1134 14.3517C39.5817 13.8828 40.3409 13.8828 40.8092 14.3517C41.2775 14.8207 41.2775 15.5811 40.8092 16.0501L37.9022 18.9617ZM22 24.8727C23.1046 24.8727 24 23.9759 24 22.8696C24 21.7634 23.1046 20.8665 22 20.8665C20.8954 20.8665 20 21.7634 20 22.8696C20 23.9759 20.8954 24.8727 22 24.8727ZM34.6665 22.8696C34.6665 23.9759 33.7711 24.8727 32.6665 24.8727C31.5619 24.8727 30.6665 23.9759 30.6665 22.8696C30.6665 21.7634 31.5619 20.8665 32.6665 20.8665C33.7711 20.8665 34.6665 21.7634 34.6665 22.8696Z"
                      fill="#DAFFE6"
                    />
                    <path
                      d="M44 39.9999V33.0006H12V39.9999C12 41.1045 12.8954 42 14 42H42C43.1046 42 44 41.1045 44 39.9999Z"
                      fill="#DAFFE6"
                    />
                  </g>
                </g>
                <defs>
                  <filter
                    id="filter0_d_19_10232"
                    x="12"
                    y="14"
                    width="33.5"
                    height="29.5"
                    filterUnits="userSpaceOnUse"
                    color-interpolation-filters="sRGB"
                  >
                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                    <feColorMatrix
                      in="SourceAlpha"
                      type="matrix"
                      values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                      result="hardAlpha"
                    />
                    <feOffset dx="1.5" dy="1.5" />
                    <feComposite in2="hardAlpha" operator="out" />
                    <feColorMatrix
                      type="matrix"
                      values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"
                    />
                    <feBlend
                      mode="normal"
                      in2="BackgroundImageFix"
                      result="effect1_dropShadow_19_10232"
                    />
                    <feBlend
                      mode="normal"
                      in="SourceGraphic"
                      in2="effect1_dropShadow_19_10232"
                      result="shape"
                    />
                  </filter>
                  <linearGradient
                    id="paint0_linear_19_10232"
                    x1="0"
                    y1="0"
                    x2="50.8755"
                    y2="60.322"
                    gradientUnits="userSpaceOnUse"
                  >
                    <stop offset="0.119792" stop-color="#A1F398" />
                    <stop offset="1" stop-color="#00D43D" />
                  </linearGradient>
                </defs>
              </svg>
            </i>
            <p>Apps</p> </a
          ><a title="News" href="news" data-dt-name="News" class=""
            ><i class="icon"
              ><svg
                width="56"
                height="56"
                viewBox="0 0 56 56"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <g id="&#231;&#177;&#187;&#229;&#158;&#139;=News">
                  <path
                    id="&#230;&#164;&#173;&#229;&#156;&#134;"
                    d="M56 28C56 47.33 47.33 56 28 56C8.67003 56 0 47.33 0 28C0 8.67003 8.67003 0 28 0C47.33 0 56 8.67003 56 28Z"
                    fill="url(#paint0_linear_19_10237)"
                  />
                  <g id="Vector" filter="url(#filter0_d_19_10237)">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M13.2536 41.7718C13.5414 41.9166 13.859 41.9946 14.1822 42C14.6532 41.9921 15.1091 41.8353 15.4823 41.5528L20.5154 37.7288H31.928C35.1297 37.7288 38.2003 36.4788 40.4642 34.2538C42.7281 32.0288 44 29.011 44 25.8644C44 22.7178 42.7281 19.7 40.4642 17.475C38.2003 15.25 35.1297 14 31.928 14H24.072C20.8703 14 17.7997 15.25 15.5358 17.475C13.2719 19.7 12 22.7178 12 25.8644V39.8553C12.0002 40.2592 12.1184 40.6546 12.3407 40.9943C12.5629 41.3341 12.8798 41.604 13.2536 41.7718ZM21.9176 24.3038H34.1196C34.4274 24.3038 34.7227 24.1836 34.9404 23.9697C35.158 23.7557 35.2803 23.4656 35.2803 23.163C35.2803 22.8604 35.158 22.5703 34.9404 22.3563C34.7227 22.1424 34.4274 22.0222 34.1196 22.0222H21.9176C21.6097 22.0222 21.3145 22.1424 21.0968 22.3563C20.8791 22.5703 20.7568 22.8604 20.7568 23.163C20.7568 23.4656 20.8791 23.7557 21.0968 23.9697C21.3145 24.1836 21.6097 24.3038 21.9176 24.3038ZM21.9176 29.8892H28.6036C28.9115 29.8892 29.2067 29.769 29.4244 29.5551C29.6421 29.3411 29.7644 29.051 29.7644 28.7484C29.7644 28.4458 29.6421 28.1557 29.4244 27.9417C29.2067 27.7278 28.9115 27.6076 28.6036 27.6076H21.9176C21.6097 27.6076 21.3145 27.7278 21.0968 27.9417C20.8791 28.1557 20.7568 28.4458 20.7568 28.7484C20.7568 29.051 20.8791 29.3411 21.0968 29.5551C21.3145 29.769 21.6097 29.8892 21.9176 29.8892Z"
                      fill="#DAF7FF"
                    />
                  </g>
                </g>
                <defs>
                  <filter
                    id="filter0_d_19_10237"
                    x="12"
                    y="14"
                    width="33.5"
                    height="29.5"
                    filterUnits="userSpaceOnUse"
                    color-interpolation-filters="sRGB"
                  >
                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                    <feColorMatrix
                      in="SourceAlpha"
                      type="matrix"
                      values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                      result="hardAlpha"
                    />
                    <feOffset dx="1.5" dy="1.5" />
                    <feComposite in2="hardAlpha" operator="out" />
                    <feColorMatrix
                      type="matrix"
                      values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"
                    />
                    <feBlend
                      mode="normal"
                      in2="BackgroundImageFix"
                      result="effect1_dropShadow_19_10237"
                    />
                    <feBlend
                      mode="normal"
                      in="SourceGraphic"
                      in2="effect1_dropShadow_19_10237"
                      result="shape"
                    />
                  </filter>
                  <linearGradient
                    id="paint0_linear_19_10237"
                    x1="0"
                    y1="0"
                    x2="50.8755"
                    y2="60.322"
                    gradientUnits="userSpaceOnUse"
                  >
                    <stop offset="0.130208" stop-color="#60E8FE" />
                    <stop offset="1" stop-color="#4491FA" />
                  </linearGradient>
                </defs>
              </svg>
            </i>
            <p>News</p> </a
          ><a
            title="Store"
            href="https://store.apkpure.com/?utm_source=quickAccessMenu&amp;utm_medium=APKPure&amp;utm_campaign=click"
            data-dt-name="Store"
            class="shan"
            target="_blank"
            rel="noopener"
          >
            <div class="tips">20% off</div>
            <img
              class="icon"
              alt="Store"
              src="https://static-sg.winudf.com/wupload/xy/aprojectadmin/S6ZN4Sq8.gif"
              width="32"
              height="32"
            />
            <p>Store</p>
          </a>
        </div>
      </div>
      <div class="right">
        <div class="search-box index_r_s">
          <form
            action="search"
            data-x_ll=""
            method="get"
            class="formsearch"
            onSubmit="onSideSearchSubmit(event)"
          >
            <span class="text-box"
              ><input
                class="autocomplete main-autocomplete"
                autocomplete="off"
                title="Enter App Name, Package Name, Package ID"
                name="q"
                type="text"
                placeholder="APKPure" /></span
            ><span class="text-btn" title="Search APK"
              ><input class="si" type="submit" value=""
            /></span>
          </form>
          <div class="trending-title">Top Categories</div>
          <div class="trending-content">
              <?php foreach ($categories as $category): ?>
                  <?php
                  // URL-encode the category name for the href
                  $encoded_category = urlencode(strtolower($category['category_name']));
                  ?>
                  <a
                      href="search?q=<?php echo htmlspecialchars($encoded_category); ?>&ici=hot_index"
                      title="<?php echo htmlspecialchars($category['category_name']); ?>"
                      class="hot"
                  >
                      <?php echo htmlspecialchars($category['category_name']); ?>
                  </a>
              <?php endforeach; ?>
          </div>
        </div>

        <div class="aegon module right_apkpure" dt-eid="card" dt-params="model_type=1032&amp;module_name=apkpure_app&amp;position=3" dt-clck-ignore="true" dt-imp-once="true" dt-imp-end-ignore="true" dt-send-beacon="true">
           
           <a class="how-to" title="How to install XAPK / APK file" href="https://apkpure.com/how-to/how-to-install-xapk-apk" rel="noopener" target="_blank" dt-eid="download_button" dt-params="small_position=1&amp;module_name=download_button&amp;package_name=com.apkpure.aegon&amp;channel_id=&amp;link_url=https%3A%2F%2Fapkpure.com%2Fhow-to%2Fhow-to-install-xapk-apk" dt-imp-once="true" dt-imp-end-ignore="true" dt-send-beacon="true">How to install XAPK / APK file</a>
          <div class="social-network"><a href="https://t.me/apkpurechannel" title="Telegram" class="network telegram" rel="nofollow noopener" target="_blank" dt-eid="share" dt-params="small_position=14&amp;name=Telegram" dt-imp-once="true" dt-imp-end-ignore="true" dt-send-beacon="true"><span>Telegram</span></a><a href="https://www.instagram.com/theofficialapkpure/" title="Instagram" class="network in" rel="nofollow noopener" target="_blank" dt-eid="share" dt-params="small_position=15&amp;name=Instagram" dt-imp-once="true" dt-imp-end-ignore="true" dt-send-beacon="true"><span>Instagram</span></a><a href="https://twitter.com/apkpure" title="Twitter X" class="network tw" rel="nofollow noopener" target="_blank" dt-eid="share" dt-params="small_position=16&amp;name=Twitter%20X" dt-imp-once="true" dt-imp-end-ignore="true" dt-send-beacon="true"><span>Twitter X</span></a><a href="https://www.youtube.com/channel/UCbCOKdnt1yYk4S3I4a034XQ" title="YouTube" class="network glp" rel="nofollow noopener" target="_blank" dt-eid="share" dt-params="small_position=17&amp;name=YouTube" dt-imp-once="true" dt-imp-end-ignore="true" dt-send-beacon="true"><span>YouTube</span></a></div>
        </div>


        



      </div>
      <div class="left">
      

         <?php foreach ($categories as $category): ?>
            <?php
            // Fetch items for this category
            try {
                $items_query = "
                    SELECT DISTINCT title, id, image_path, app_rating
                    FROM allwallpaper
                    WHERE category_id = :category_id
                    ORDER BY app_rating DESC
                ";
                $items_stmt = $dbh->prepare($items_query);
                $items_stmt->execute(['category_id' => $category['id']]);
                $items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($items)):
            ?>
                <div class="module popular-games">
                    <a class="title more" title="<?php echo htmlspecialchars($category['category_name']); ?>" href="/category/<?php echo $category['id']; ?>/items">
                        <h3 class="name"><?php echo htmlspecialchars($category['category_name']); ?></h3>
                    </a>
                    <div class="apk-list-1002">
                        <?php foreach ($items as $item):
                            // Generate a slug-like title for the href
                            $title_slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $item['title']));
                        ?>
                            <a
                                class="apk"
                                title="<?php echo htmlspecialchars($item['title']); ?>"
                                href="<?php echo htmlspecialchars($title_slug . '/' . $item['id']); ?>"
                                data-dt-app="<?php echo htmlspecialchars($item['id']); ?>"
                            >
                                <div class="img-ratio">
                                    <img
                                        class="icon lazy"
                                        alt="<?php echo htmlspecialchars($item['title']); ?>"
                                        src="/admin/<?php echo htmlspecialchars($item['image_path']); ?>"
                                        width="102"
                                        height="102"
                                    />
                                </div>
                                <div class="name double-lines"><?php echo htmlspecialchars($item['title']); ?></div>
                                <div class="score"><?php echo number_format($item['app_rating'], 1); ?></div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php
                endif;
            } catch (PDOException $e) {
                echo "<p>Error fetching items for category {$category['category_name']}: " . $e->getMessage() . "</p>";
            }
            ?>
        <?php endforeach; ?>
 

       

        <div class="module popular-articles">
        <a class="title more" title="Popular Articles In Last 24 Hours" href="search?q=popular_article&sat=articles&ao=most&at=home_recommend">
            <h3 class="name">Popular Blog  </h3>
        </a>
        <div class="article-list">
            <?php if (empty($blogs)): ?>
                <p>No blog posts found.</p>
            <?php else: ?>
                <?php foreach ($blogs as $blog): ?>
                    <a
                        class="article"
                        href="/news/<?php echo htmlspecialchars($blog['slug']); ?>"
                        title="<?php echo htmlspecialchars($blog['title']); ?>"
                        data-dt-article-id="<?php echo htmlspecialchars($blog['id']); ?>"
                        data-dt-article-type="2"
                    >
                        <img
                            class="article-banner lazy"
                            alt="<?php echo htmlspecialchars($blog['title']); ?>"
                            src="/admin/<?php echo htmlspecialchars($blog['image_path']); ?>"
                            width="142"
                            height="80"
                        />
                        <div class="text">
                            <div class="article-title double-lines">
                                <?php echo htmlspecialchars($blog['title']); ?>
                            </div>
                            <div class="updated one-line">
                                <?php echo date('F j, Y', strtotime($blog['updated_at'])); ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>


      </div>



      
      <div class="right">
        <div class="module editor-choice">
          <a
            class="title more"
            title="Weekly Editor&#39;s Recommendation"
            href="/editor-choice"
          >
            <h3 class="name">Weekly Editor&#39;s Recommendation</h3>
          </a>
          <div class="apk-list-1003 no-scrollbar">
            <a
              class="apk"
              title="War Sniper: FPS Shooting Game APK"
              href="war-sniper-fps-shooting-game/com.miniclip.puresoldier"
              data-dt-app="com.miniclip.puresoldier"
              data-dt-recid=""
              ><img
                class="banner lazy"
                alt="War Sniper: FPS Shooting Game APK"
                src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                data-original="https://image.winudf.com/v2/image1/Y29tLm1pbmljbGlwLnB1cmVzb2xkaWVyX2Jhbm5lcl8xNzE5NDM3MDAyXzA2Mw/banner.jpg?w=260&amp;fakeurl=1&amp;type=.webp"
                data-srcset="https://image.winudf.com/v2/image1/Y29tLm1pbmljbGlwLnB1cmVzb2xkaWVyX2Jhbm5lcl8xNzE5NDM3MDAyXzA2Mw/banner.jpg?w=520&amp;fakeurl=1&amp;type=.webp 2x"
                width="260"
                height="134"
              />
              <div class="info">
                <img
                  class="icon lazy"
                  alt="War Sniper: FPS Shooting Game APK"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/Y29tLm1pbmljbGlwLnB1cmVzb2xkaWVyX2ljb25fMTc0NDcyMjg3OF8wOTU/icon.webp?w=60&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/Y29tLm1pbmljbGlwLnB1cmVzb2xkaWVyX2ljb25fMTc0NDcyMjg3OF8wOTU/icon.webp?w=120&amp;fakeurl=1&amp;type=.webp"
                  width="48"
                  height="48"
                />
                <div class="text">
                  <div class="name one-line">War Sniper: FPS Shooting Game</div>
                  <div class="desc one-line">
                    Engage in military battles &amp; take down soldiers in this
                    FPS gun shooting game
                  </div>
                </div>
                <div class="score">6.0</div>
              </div> </a
            ><a
              class="apk"
              title="Dynamons World APK"
              href="dynamons-world/com.funtomic.dynamons3"
              data-dt-app="com.funtomic.dynamons3"
              data-dt-recid=""
              ><img
                class="banner lazy"
                alt="Dynamons World APK"
                src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                data-original="https://image.winudf.com/v2/image1/Y29tLmZ1bnRvbWljLmR5bmFtb25zM19iYW5uZXJfMTY2NDAyNjkyN18wNDY/banner.jpg?w=260&amp;fakeurl=1&amp;type=.webp"
                data-srcset="https://image.winudf.com/v2/image1/Y29tLmZ1bnRvbWljLmR5bmFtb25zM19iYW5uZXJfMTY2NDAyNjkyN18wNDY/banner.jpg?w=520&amp;fakeurl=1&amp;type=.webp 2x"
                width="260"
                height="134"
              />
              <div class="info">
                <img
                  class="icon lazy"
                  alt="Dynamons World APK"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/Y29tLmZ1bnRvbWljLmR5bmFtb25zM19pY29uXzE2OTUxOTM4ODhfMDc2/icon.webp?w=60&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/Y29tLmZ1bnRvbWljLmR5bmFtb25zM19pY29uXzE2OTUxOTM4ODhfMDc2/icon.webp?w=120&amp;fakeurl=1&amp;type=.webp"
                  width="48"
                  height="48"
                />
                <div class="text">
                  <div class="name one-line">Dynamons World</div>
                  <div class="desc one-line">
                    Catch all creatures in this open world RPG game with online
                    PvP battles.
                  </div>
                </div>
                <div class="score">9.0</div>
              </div> </a
            ><a
              class="apk"
              title="Polyfield APK"
              href="polyfield/com.MA.Polyfield"
              data-dt-app="com.MA.Polyfield"
              data-dt-recid=""
              ><img
                class="banner lazy"
                alt="Polyfield APK"
                src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                data-original="https://image.winudf.com/v2/image1/Y29tLk1BLlBvbHlmaWVsZF9iYW5uZXJfMTcxMjQ1Njg5N18wMTg/banner.jpg?w=260&amp;fakeurl=1&amp;type=.webp"
                data-srcset="https://image.winudf.com/v2/image1/Y29tLk1BLlBvbHlmaWVsZF9iYW5uZXJfMTcxMjQ1Njg5N18wMTg/banner.jpg?w=520&amp;fakeurl=1&amp;type=.webp 2x"
                width="260"
                height="134"
              />
              <div class="info">
                <img
                  class="icon lazy"
                  alt="Polyfield APK"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/Y29tLk1BLlBvbHlmaWVsZF9pY29uXzE2MzQzMjAyOTJfMDkx/icon.webp?w=60&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/Y29tLk1BLlBvbHlmaWVsZF9pY29uXzE2MzQzMjAyOTJfMDkx/icon.webp?w=120&amp;fakeurl=1&amp;type=.webp"
                  width="48"
                  height="48"
                />
                <div class="text">
                  <div class="name one-line">Polyfield</div>
                  <div class="desc one-line">
                    Large scale 32vs32 multiplayer combat set in WW2
                  </div>
                </div>
                <div class="score">8.7</div>
              </div> </a
            ><a
              class="apk"
              title="West Game APK"
              href="west-game/leyi.westgame"
              data-dt-app="leyi.westgame"
              data-dt-recid=""
              ><img
                class="banner lazy"
                alt="West Game APK"
                src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                data-original="https://image.winudf.com/v2/image1/bGV5aS53ZXN0Z2FtZV9iYW5uZXJfMTU1NDc4ODQ2MV8wOTg/banner.jpg?w=260&amp;fakeurl=1&amp;type=.webp"
                data-srcset="https://image.winudf.com/v2/image1/bGV5aS53ZXN0Z2FtZV9iYW5uZXJfMTU1NDc4ODQ2MV8wOTg/banner.jpg?w=520&amp;fakeurl=1&amp;type=.webp 2x"
                width="260"
                height="134"
              />
              <div class="info">
                <img
                  class="icon lazy"
                  alt="West Game APK"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/bGV5aS53ZXN0Z2FtZV9pY29uXzE3NDczNzU3NzJfMDcy/icon.webp?w=60&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/bGV5aS53ZXN0Z2FtZV9pY29uXzE3NDczNzU3NzJfMDcy/icon.webp?w=120&amp;fakeurl=1&amp;type=.webp"
                  width="48"
                  height="48"
                />
                <div class="text">
                  <div class="name one-line">West Game</div>
                  <div class="desc one-line">The Old West theme SLG game.</div>
                </div>
                <div class="score">8.1</div>
              </div> </a
            ><a
              class="apk"
              title="Stormbound: PVP Card Battle APK"
              href="stormbound-kingdom-wars/com.kongregate.mobile.stormbound.google"
              data-dt-app="com.kongregate.mobile.stormbound.google"
              data-dt-recid=""
              ><img
                class="banner lazy"
                alt="Stormbound: PVP Card Battle APK"
                src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                data-original="https://image.winudf.com/v2/image1/Y29tLmtvbmdyZWdhdGUubW9iaWxlLnN0b3JtYm91bmQuZ29vZ2xlX2Jhbm5lcl8xNTU1NDAxNDYwXzAzNg/banner.jpg?w=260&amp;fakeurl=1&amp;type=.webp"
                data-srcset="https://image.winudf.com/v2/image1/Y29tLmtvbmdyZWdhdGUubW9iaWxlLnN0b3JtYm91bmQuZ29vZ2xlX2Jhbm5lcl8xNTU1NDAxNDYwXzAzNg/banner.jpg?w=520&amp;fakeurl=1&amp;type=.webp 2x"
                width="260"
                height="134"
              />
              <div class="info">
                <img
                  class="icon lazy"
                  alt="Stormbound: PVP Card Battle APK"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/Y29tLmtvbmdyZWdhdGUubW9iaWxlLnN0b3JtYm91bmQuZ29vZ2xlX2ljb25fMTYyMjU5NTIzNF8wNTk/icon.webp?w=60&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/Y29tLmtvbmdyZWdhdGUubW9iaWxlLnN0b3JtYm91bmQuZ29vZ2xlX2ljb25fMTYyMjU5NTIzNF8wNTk/icon.webp?w=120&amp;fakeurl=1&amp;type=.webp"
                  width="48"
                  height="48"
                />
                <div class="text">
                  <div class="name one-line">Stormbound: PVP Card Battle</div>
                  <div class="desc one-line">
                    Collect Cards, build decks and face enemies in real-time PVP
                    battles!
                  </div>
                </div>
                <div class="score">8.0</div>
              </div> </a
            ><a
              class="apk"
              title="Music Player - MP3 Player APK"
              href="music-player-mp3-player/freemusic.equalizer.bassbooster.musicplayer"
              data-dt-app="freemusic.equalizer.bassbooster.musicplayer"
              data-dt-recid=""
              ><img
                class="banner lazy"
                alt="Music Player - MP3 Player APK"
                src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                data-original="https://image.winudf.com/v2/image1/ZnJlZW11c2ljLmVxdWFsaXplci5iYXNzYm9vc3Rlci5tdXNpY3BsYXllcl9iYW5uZXJfMTYyMTUxNTY2Nl8wODk/banner.jpg?w=260&amp;fakeurl=1&amp;type=.webp"
                data-srcset="https://image.winudf.com/v2/image1/ZnJlZW11c2ljLmVxdWFsaXplci5iYXNzYm9vc3Rlci5tdXNpY3BsYXllcl9iYW5uZXJfMTYyMTUxNTY2Nl8wODk/banner.jpg?w=520&amp;fakeurl=1&amp;type=.webp 2x"
                width="260"
                height="134"
              />
              <div class="info">
                <img
                  class="icon lazy"
                  alt="Music Player - MP3 Player APK"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/ZnJlZW11c2ljLmVxdWFsaXplci5iYXNzYm9vc3Rlci5tdXNpY3BsYXllcl9pY29uXzE2MzI3NTIyMzJfMDgx/icon.webp?w=60&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/ZnJlZW11c2ljLmVxdWFsaXplci5iYXNzYm9vc3Rlci5tdXNpY3BsYXllcl9pY29uXzE2MzI3NTIyMzJfMDgx/icon.webp?w=120&amp;fakeurl=1&amp;type=.webp"
                  width="48"
                  height="48"
                />
                <div class="text">
                  <div class="name one-line">Music Player - MP3 Player</div>
                  <div class="desc one-line">
                    Music Player &amp; Audio Player supports all formats,
                    equalizer and themes.
                  </div>
                </div>
                <div class="score">10.0</div>
              </div> </a
            ><a
              class="apk"
              title="Fancade: Simple Games APK"
              href="fancade/com.martinmagni.fancade"
              data-dt-app="com.martinmagni.fancade"
              data-dt-recid=""
              ><img
                class="banner lazy"
                alt="Fancade: Simple Games APK"
                src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                data-original="https://image.winudf.com/v2/image1/Y29tLm1hcnRpbm1hZ25pLmZhbmNhZGVfYmFubmVyXzE2MjM0MTM5MTdfMDgw/banner.jpg?w=260&amp;fakeurl=1&amp;type=.webp"
                data-srcset="https://image.winudf.com/v2/image1/Y29tLm1hcnRpbm1hZ25pLmZhbmNhZGVfYmFubmVyXzE2MjM0MTM5MTdfMDgw/banner.jpg?w=520&amp;fakeurl=1&amp;type=.webp 2x"
                width="260"
                height="134"
              />
              <div class="info">
                <img
                  class="icon lazy"
                  alt="Fancade: Simple Games APK"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/Y29tLm1hcnRpbm1hZ25pLmZhbmNhZGVfaWNvbl8xNzQ2NDQ1OTg0XzAwMQ/icon.webp?w=60&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/Y29tLm1hcnRpbm1hZ25pLmZhbmNhZGVfaWNvbl8xNzQ2NDQ1OTg0XzAwMQ/icon.webp?w=120&amp;fakeurl=1&amp;type=.webp"
                  width="48"
                  height="48"
                />
                <div class="text">
                  <div class="name one-line">Fancade: Simple Games</div>
                  <div class="desc one-line">
                    Simple games. And lots of them! Unlock a world of
                    mini-games, or make your own?
                  </div>
                </div>
                <div class="score">8.4</div>
              </div> </a
            ><a
              class="apk"
              title="Coin Tales APK"
              href="coin-tales/com.moonjoy.cointale"
              data-dt-app="com.moonjoy.cointale"
              data-dt-recid=""
              ><img
                class="banner lazy"
                alt="Coin Tales APK"
                src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                data-original="https://image.winudf.com/v2/image1/Y29tLm1vb25qb3kuY29pbnRhbGVfYmFubmVyXzE3MzM5MTgzNDFfMDc3/banner.jpg?w=260&amp;fakeurl=1&amp;type=.webp"
                data-srcset="https://image.winudf.com/v2/image1/Y29tLm1vb25qb3kuY29pbnRhbGVfYmFubmVyXzE3MzM5MTgzNDFfMDc3/banner.jpg?w=520&amp;fakeurl=1&amp;type=.webp 2x"
                width="260"
                height="134"
              />
              <div class="info">
                <img
                  class="icon lazy"
                  alt="Coin Tales APK"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/Y29tLm1vb25qb3kuY29pbnRhbGVfaWNvbl8xNzA4OTQ3MjIzXzAwMw/icon.webp?w=60&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/Y29tLm1vb25qb3kuY29pbnRhbGVfaWNvbl8xNzA4OTQ3MjIzXzAwMw/icon.webp?w=120&amp;fakeurl=1&amp;type=.webp"
                  width="48"
                  height="48"
                />
                <div class="text">
                  <div class="name one-line">Coin Tales</div>
                  <div class="desc one-line">
                    Connect, compete, and create fun with friends in Coin Tales!
                  </div>
                </div>
                <div class="score">10.0</div>
              </div> </a
            ><a
              class="apk"
              title="GoArt - Ghibli Style AI Image APK"
              href="ai-art-image-generator-%E2%80%93-goart/com.everimaging.goart"
              data-dt-app="com.everimaging.goart"
              data-dt-recid=""
              ><img
                class="banner lazy"
                alt="GoArt - Ghibli Style AI Image APK"
                src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                data-original="https://image.winudf.com/v2/image1/Y29tLmV2ZXJpbWFnaW5nLmdvYXJ0X2Jhbm5lcl8xNzQzNjgwODUwXzAyMQ/banner.jpg?w=260&amp;fakeurl=1&amp;type=.webp"
                data-srcset="https://image.winudf.com/v2/image1/Y29tLmV2ZXJpbWFnaW5nLmdvYXJ0X2Jhbm5lcl8xNzQzNjgwODUwXzAyMQ/banner.jpg?w=520&amp;fakeurl=1&amp;type=.webp 2x"
                width="260"
                height="134"
              />
              <div class="info">
                <img
                  class="icon lazy"
                  alt="GoArt - Ghibli Style AI Image APK"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/Y29tLmV2ZXJpbWFnaW5nLmdvYXJ0X2ljb25fMTY2OTA0MDY1OF8wMTI/icon.webp?w=60&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/Y29tLmV2ZXJpbWFnaW5nLmdvYXJ0X2ljb25fMTY2OTA0MDY1OF8wMTI/icon.webp?w=120&amp;fakeurl=1&amp;type=.webp"
                  width="48"
                  height="48"
                />
                <div class="text">
                  <div class="name one-line">GoArt - Ghibli Style AI Image</div>
                  <div class="desc one-line">
                    Ghibli Studio AI Art Photo Generator,Anime
                    Filter,Portrait,Action Figure Maker
                  </div>
                </div>
                <div class="score">9.5</div>
              </div> </a
            ><a
              class="apk"
              title="Drive Zone Online APK"
              href="drive-zone-car-simulator-game/com.drivezone.car.race.game"
              data-dt-app="com.drivezone.car.race.game"
              data-dt-recid=""
              ><img
                class="banner lazy"
                alt="Drive Zone Online APK"
                src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                data-original="https://image.winudf.com/v2/image1/Y29tLmRyaXZlem9uZS5jYXIucmFjZS5nYW1lX2Jhbm5lcl8xNjkyOTg5NDY5XzAwNg/banner.jpg?w=260&amp;fakeurl=1&amp;type=.webp"
                data-srcset="https://image.winudf.com/v2/image1/Y29tLmRyaXZlem9uZS5jYXIucmFjZS5nYW1lX2Jhbm5lcl8xNjkyOTg5NDY5XzAwNg/banner.jpg?w=520&amp;fakeurl=1&amp;type=.webp 2x"
                width="260"
                height="134"
              />
              <div class="info">
                <img
                  class="icon lazy"
                  alt="Drive Zone Online APK"
                  src="data:image/gif;base64,R0lGODlhAQABAPAAAPX19QAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQEAgD/ACwAAAAAAQABAAACAkQBADs="
                  data-original="https://image.winudf.com/v2/image1/Y29tLmRyaXZlem9uZS5jYXIucmFjZS5nYW1lX2ljb25fMTcxMzI2NjcwNV8wMzY/icon.webp?w=60&amp;fakeurl=1&amp;type=.webp"
                  data-srcset="https://image.winudf.com/v2/image1/Y29tLmRyaXZlem9uZS5jYXIucmFjZS5nYW1lX2ljb25fMTcxMzI2NjcwNV8wMzY/icon.webp?w=120&amp;fakeurl=1&amp;type=.webp"
                  width="48"
                  height="48"
                />
                <div class="text">
                  <div class="name one-line">Drive Zone Online</div>
                  <div class="desc one-line">
                    Enjoy the open-world car driving gameplay in Drive Zone
                    Online!
                  </div>
                </div>
                <div class="score">7.6</div>
              </div>
            </a>
          </div>
        </div>
      </div>
      
      
       
     </div>
<?php include "includes/footer.php" ?>
