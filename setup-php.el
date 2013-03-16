(defun setup-multi-web-mode ()
  (require 'php-mode)
  (require 'php+-mode)
  (php+-mode-setup)

  (require 'multi-web-mode)
  (setq mweb-default-major-mode 'html-mode)
  (setq mweb-tags '((php-mode "<\\?php\\|<\\? \\|<\\?=" "\\?>")
                    (js-mode "<script +\\(type=\"text/javascript\"\\|language=\"javascript\"\\)[^>]*>" "</script>")
                    (css-mode "<style +type=\"text/css\"[^>]*>" "</style>")))
  (setq mweb-filename-extensions '("htm" "html" "ctp" "phtml"))
  (multi-web-global-mode 1))

(add-hook 'after-init-hook 'setup-multi-web-mode)
(add-hook 'php+-mode-hook (lambda ()
                            (add-hook 'before-save-hook 'untabify-buffer)
                            (require 'php-electric)
                            (php-electric-mode)
                            (require 'flymake-php)
                            (flymake-php-load)))

(custom-set-variables
 ;; custom-set-variables was added by Custom.
 ;; If you edit it by hand, you could mess it up, so be careful.
 ;; Your init file should contain only one such instance.
 ;; If there is more than one, they won't work right.
 '(php+-mode-delete-trailing-whitespace t)
 '(php+-mode-php-compile-on-save nil)
 '(php+-mode-show-project-in-modeline t)
 '(php+-mode-show-trailing-whitespace t)
 '(php-doc-default-author (quote ("Ole-Kenneth Rangnes" . "ok@vg.no")))
 '(php-file-patterns (quote ("\\.php[s345t]?\\'" "\\.inc\\'")))
 '(php-html-basic-offset 4)
 ;; '(php-project-list (quote (("direkte" "~/webdev/html/livestudio" "~/webdev/html/livestudio/TAGS" nil "" nil (("" . "") "" "" "" "" "" "" "" "") "Livestudio" ""))))
 '(phpcs-standard "PHPCS"))

(add-hook 'html-mode-hook
          (lambda ()
            (set (make-local-variable 'sgml-basic-offset) 4)))

(provide 'setup-php)
