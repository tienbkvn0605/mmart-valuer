<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>《Bnet》商品特徴登録｜編集</title>
		<link rel="stylesheet" href="/outlet/valeur/common/css/uikit.min.css">
		<link rel="stylesheet" href="/outlet/valeur/common/css/uikit-plusa.min.css">
		<script src="/outlet/valeur/common/js/jquery.min.js"></script>
		<script src="/outlet/valeur/common/js/uikit.min.js"></script>
		<script src="/outlet/valeur/common/js/uikit-icons.min.js"></script>
		<script src="/outlet/valeur/common/js/uikit-plusa.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <style>
            #container {
                /* width: 1200px; */
                width: 80%;
                margin: 20px auto;
            }
            .ck-editor__editable[role="textbox"] {
                /* Editing area */
                min-height: 200px;
            }
            .ck-content .image {
                /* Block images */
                max-width: 80%;
                margin: 20px auto;
            }

			#button_area{
				text-align: center
			}

        </style>
        <section class="container-fluid mt-3">
            <?php include_once('/var/www/html3/outlet/valeur/seller/tpl/tpl_header.php')?>
        </section>
        
		<form method="post" id="feature_form" action="/outlet/valeur/seller/item_feature.php?p_kind=save_feature&ai_serial=<?php echo $f_ai_serial?>">
        <div id="container">
			<table class="uk-table ukp-table-border">
				<tr class="uk-text-small">
					<td>
						<button uk-toggle="target: #annotation" type="button" class="uk-button uk-button-primary uk-button-small uk-text-bold">アイコン説明</button>
						<span class="uk-label uk-label-warning">制限サイズ：<?php echo number_format(DF_content_size)?> bytes</span>
					</td>
				</tr>
			</table>
            <div id="editor">
            </div>
			<div class="byte_content">バイト数：<span class="content_size"></span>/&nbsp;<?php echo number_format(DF_content_size)?>（<span class="size_settup"></span>）</div>
        </div>
		<input type="hidden" name="contents" value="">
		
		</form>
        <!--
            The "superbuild" of CKEditor&nbsp;5 served via CDN contains a large set of plugins and multiple editor types.
            See https://ckeditor.com/docs/ckeditor5/latest/installation/getting-started/quick-start.html#running-a-full-featured-editor-from-cdn
        -->
        <!-- <script src="/rep/js/common/jquery.min.js"></script> -->
        <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/super-build/ckeditor.js"></script>
		<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/super-build/translations/ja.js"></script>
        <!--
            Uncomment to load the Spanish translation
            <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/super-build/translations/es.js"></script>
        -->
        <script>
            // This sample still does not showcase all CKEditor&nbsp;5 features (!)
            // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
            let editor;
			CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        // 'exportPDF','exportWord', '|',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        '-',
                        // 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
						'fontSize', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        // 'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
						'uploadImage', 'blockQuote', 'insertTable', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        // 'textPartLanguage', '|',
						'undo', 'redo',
                        // 'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
				language: 'ja',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: '商品詳細をご自由に編集してください！',
                
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [ 8, 9, 10, 12, 14, 'default', 18, 20, 22, 24, 26, 28, 30, 32, 36 ],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                // The "superbuild" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                removePlugins: [
                    // These two are commercial, but you can try them out without registering to a trial.
                    'ExportPdf',
                    'ExportWord',
                    'AIAssistant',
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                    // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                    // Storing images as Base64 is usually a very bad idea.
                    // Replace it on production website with other solutions:
                    // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                    // 'Base64UploadAdapter',
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                    // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                    'MathType',
                    // The following features are part of the Productivity Pack and require additional license.
                    'SlashCommand',
                    'Template',
                    'DocumentOutline',
                    'FormatPainter',
                    'TableOfContents',
                    'PasteFromOfficeEnhanced',
                    'CaseChange'
                ]
            }).then( instance => {
				editor = instance;
				editor.setData('<?php echo ($contents);?>');

				var byte_content = getByteLengthText(editor.getData())
				$('.byte_content .content_size').html(byte_content.toLocaleString()+'（'+UnitChangeForByte(byte_content)+'）')

				editor.model.document.on('change:data', (byte_content) => {
					byte_content = getByteLengthText(editor.getData())
					$('.byte_content .content_size').html(byte_content.toLocaleString()+'（'+UnitChangeForByte(byte_content)+'）')
				})

				let button_area = `<div id="button_area">
					<input type="submit" class="uk-button uk-button-primary" value=" 保 存 " id="submit_btn">&emsp;&emsp;
					<button class="uk-button uk-button-danger close-feature">閉じる</button>
				</div>`;
                
				$("#feature_form").append(button_area);
                <?php if (!empty($success)){ ?>
                        let message = `<div class="uk-alert-success" uk-alert>
                                        <a href class="uk-alert-close" uk-close></a>
                                        <p><?php echo $message?></p>
                                    </div>`;
                        $("#container").prepend(message);
                <?php } ?>
				
				
			
                <?php if (isset($success) && $success == false){ ?>
                        let message = `<div class="uk-alert-danger" uk-alert>
                                        <a href class="uk-alert-close" uk-close></a>
                                        <p><?php echo $message?></p>
                                    </div>`;
                        $("#container").prepend(message);
                  <?php } ?>
				
			});


			$(function(){
				$("#submit_btn").click(function(e){
					const editor_data = editor.getData();
                    if(!editor_data){

                    }
					$("input[name='contents']").val(editor_data);
				})

				$(document).on("click",".close-feature", function(e){
					e.preventDefault();
					window.open('','_parent','');
    				window.close();
				})
			});
			function getByteLengthText(str) {
				const encoder = new TextEncoder();
				return encoder.encode(str).length;
			}
			const UnitChangeForByte = (size) => {
				const { target, unit } = getTarget(size)
				const newSize = target !== null ? Math.floor((size / target) * Math.pow(10, 2)) / Math.pow(10, 2) : size
				return newSize + unit
			}
			function getTarget (size) {
				const kb = 1024
				const mb = Math.pow(kb, 2)
				const gb = Math.pow(kb, 3)
				const tb = Math.pow(kb, 4)

				if (size >= tb) return { target: tb, unit: 'TB' }
				if (size >= gb) return { target: gb, unit: 'GB' }
				if (size >= mb) return { target: mb, unit: 'MB' }
				if (size >= kb) return { target: kb, unit: 'KB' }

				return { target: null, unit: 'byte' }
			}
			var size_settup = UnitChangeForByte(<?php echo (DF_content_size)?>)
			$(".byte_content .size_settup").html(size_settup);
        </script>
         
        
		<div id="annotation" class="uk-flex-top uk-modal-container" uk-modal>
			<div class="uk-modal-dialog uk-margin-auto-vertical uk-modal-body">
				<table class="uk-table ukp-table-border">
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon1.png"></td>
						<td class="uk-text-middle">全体コンテンツを検索し、検索したキーワードを別キーワードに置換することができます。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon2.png"></td>
						<td class="uk-text-middle">入力コンテンツのすべてを選択する。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon3.png"></td>
						<td class="uk-text-middle">見出しを選択する。（タグは後述する「Headings」で選択可能）</td>
					</tr>
					
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon8.png"></td>
						<td class="uk-text-middle">コード（&lt;code&gt;タグ）をつける。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon9.png"></td>
						<td class="uk-text-middle">下付き文字をつける。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon10.png"></td>
						<td class="uk-text-middle">上付き文字をつける。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon11.png"></td>
						<td class="uk-text-middle">選択した文字の装飾を削除する。</td>
					</tr>
				
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon13.png"></td>
						<td class="uk-text-middle">箇条書きリスト、番号付きリスト、✔チェックリスト（&lt;ul&gt;タグ）を追加する。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon14.png"></td>
						<td class="uk-text-middle">文字やリストのインデントをする、またはアウトデントをする。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon15.png"></td>
						<td class="uk-text-middle">文字の大きさを選択する。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon16.png"></td>
						<td class="uk-text-middle">文字色を選択する。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon17.png"></td>
						<td class="uk-text-middle">文字の背景色を選択する。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon18.png"></td>
						<td class="uk-text-middle">文字にハイライトをつける。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon19.png"></td>
						<td class="uk-text-middle">文字揃えを行う（「text-align-center」などのclassがつく）。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon20.png"></td>
						<td class="uk-text-middle">画像をアップロードする。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon21.png"></td>
						<td class="uk-text-middle">引用ブロックを追加する。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon22.png"></td>
						<td class="uk-text-middle">◯ｘ◯ 表を追加する。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon23.png"></td>
						<td class="uk-text-middle">特殊文字を追加する。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon24.png"></td>
						<td class="uk-text-middle">ツールバー上で区切りの役割をするアイコンを表示する。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon25.png"></td>
						<td class="uk-text-middle">このボタン以降をツールバーの次の行へ移動する（改ページ）。</td>
					</tr>
					<tr class="uk-text-small">
						<td class="uk-text-center"><img src="/outlet/valeur/common/img/icon26.png"></td>
						<td class="uk-text-middle">操作の取り消し、または操作のやり直し（Undoした内容を元に戻す）。</td>
					</tr>
				</table>
				<button class="uk-modal-close-default" type="button" uk-close></button>
			</div>
		</div>
    </body>
</html>
