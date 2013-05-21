;; Load path etc.
(setq dotfiles-dir (file-name-directory
                    (or (buffer-file-name) load-file-name)))

(add-to-list 'load-path dotfiles-dir)
(add-to-list 'load-path "~/.emacs.d/vendor/")
(add-to-list 'load-path "~/.emacs.d/vendor/phpplus-mode")
(add-to-list 'load-path "~/.emacs.d/vendor/emacs-flymake-phpcs")

;; ELPA
(setq package-archives '(("gnu" . "http://elpa.gnu.org/packages/")
                         ("marmalade" . "http://marmalade-repo.org/packages")
                         ("melpa" . "http://melpa.milkbox.net/packages/")))

(set-terminal-coding-system 'utf-8)
(set-keyboard-coding-system 'utf-8)
(prefer-coding-system 'utf-8)
(ansi-color-for-comint-mode-on)

;; Disable startup screen
;; (setq inhibit-startup-message t)

(if (fboundp 'menu-bar-mode) (menu-bar-mode -1))
(if (fboundp 'tool-bar-mode) (tool-bar-mode -1))
(if (fboundp 'scroll-bar-mode) (scroll-bar-mode -1))

;; Transparently open compressed files
(auto-compression-mode t)

;; Save a list of recent files visited.
(recentf-mode 1)

;; enable column-number-mode
(column-number-mode t)

;; show paren mode
(show-paren-mode t)

;; show line numbers on the side
(global-linum-mode t)

;; Disable newline at end of file
(setq mode-require-final-newline nil)
(setq require-final-newline nil)

;; Set UTF-8 and LF
(set-buffer-file-coding-system 'utf-8-unix t)

(defvar my-linum-format-string "%3d")

(add-hook 'linum-before-numbering-hook 'my-linum-get-format-string)

(defun my-linum-get-format-string ()
  (let* ((width (1+ (length (number-to-string
                             (count-lines (point-min) (point-max))))))
         (format (concat "%" (number-to-string width) "d")))
    (setq my-linum-format-string format)))

(defvar my-linum-current-line-number 0)

(setq linum-format 'my-linum-relative-line-numbers)

(defun my-linum-relative-line-numbers (line-number)
  (let ((offset (abs (- line-number my-linum-current-line-number))))
    (propertize (format my-linum-format-string offset) 'face 'linum)))

(defadvice linum-update (around my-linum-update)
  (let ((my-linum-current-line-number (line-number-at-pos)))
    ad-do-it))
(ad-activate 'linum-update)

;; Auto update buffer from file, when not modified
(global-auto-revert-mode t)

(ido-mode t)
(setq ido-enable-prefix nil
      ido-enable-flex-matching t
      ido-create-new-buffer 'always
      ido-use-filename-at-point 'guess
      ido-max-prospects 10)

(set-default 'indent-tabs-mode nil)
(set-default 'indicate-empty-lines t)
(set-default 'imenu-auto-rescan t)

;; Uniquify
(require 'uniquify)
(setq uniquify-buffer-name-style 'forward)

(defalias 'yes-or-no-p 'y-or-n-p)

(random t) ;; Seed the random-number generator

;; Don't clutter up directories with files~
(setq backup-directory-alist `(("." . ,(expand-file-name
                                        (concat dotfiles-dir "backups")))))

;; Default to unified diffs
(setq diff-switches "-u -w")

(eval-after-load 'diff-mode
  '(progn
     (set-face-foreground 'diff-added "green4")
     (set-face-foreground 'diff-removed "red3")))

(eval-after-load 'magit
  '(progn
     (set-face-foreground 'magit-diff-add "green3")
     (set-face-foreground 'magit-diff-del "red3")))


;; After elpa load
(defun my-after-init ()
  (require 'twilight-theme))
(add-hook 'after-init-hook 'my-after-init)

;; Javascript
(add-to-list 'auto-mode-alist '(".js$" . js2-mode))

(font-lock-add-keywords
 'js2-mode `(("\\(function *\\)("
              (0 (progn (compose-region (match-beginning 1)
                                        (match-end 1) "f")
                        nil)))))



(defun bury-compile-buffer-if-successful (buffer string)
  "Bury a compilation buffer if succeeded without warnings"
  (if (and
       (string-match "compilation" (buffer-name buffer))
       (string-match "finished" string)
       (not
        (with-current-buffer buffer
          (search-forward "warning" nil t))))
      (run-with-timer 0.01 nil
                      (lambda (buf)
                        (bury-buffer buf)
                        (delete-window (get-buffer-window buf))
                        (kill-buffer buf)
                        (shell-command "growlnotify -m 'Success' -t 'PHP Compilation' --appIcon 'Emacs' &> /dev/null")
                        )
                      buffer)))
(add-hook 'compilation-finish-functions 'bury-compile-buffer-if-successful)

;;kill-buffer-and-window

;; If flymake_phpcs isn't found correctly, specify the full path
;; (setq flymake-phpcs-command "/Users/olekenneth/.emacs.d/vendor/emacs-flymake-phpcs/bin/flymake_phpcs")
;; Customize the coding standard checked by phpcs
(setq flymake-phpcs-standard "/Users/olekenneth/.emacs.d/VG")

;; Show the name of sniffs in warnings (eg show
;; "Generic.CodeAnalysis.VariableAnalysis.UnusedVariable" in an unused
;; variable warning)
(setq flymake-phpcs-show-rule t)

;; Growl
(require 'growl)

(require 'flymake-phpcs)
(require 'psvn)
(require 'misc-func)
(require 'key-bindings)
(require 'setup-php)
(require 'setup-scss)

(custom-set-faces
 ;; custom-set-faces was added by Custom.
 ;; If you edit it by hand, you could mess it up, so be careful.
 ;; Your init file should contain only one such instance.
 ;; If there is more than one, they won't work right.
 )
