(flycheck-declare-checker flycheck-checker-jslint
  "jslint checker"
  :command '("jsl" "-process" source)
  :error-patterns '(("^\\(.+\\)\:\\([0-9]+\\)\: \\(SyntaxError\:.+\\)\:$" error)
                    ("^\\(.+\\)(\\([0-9]+\\)): \\(SyntaxError:.+\\)$" error)
                    ("^\\(.+\\)(\\([0-9]+\\)): \\(lint \\)?\\(warning:.+\\)$" warning)
                    ("^\\(.+\\)\:\\([0-9]+\\)\: strict \\(warning: trailing comma.+\\)\:$" warning))
  :modes 'js2-mode)

(defun my-after-init-js ()
  "After js init hook."
  (require 'flycheck)
  (add-to-list 'flycheck-checkers 'flycheck-checker-jslint))

(add-hook 'after-init-hook 'my-after-init-js)

(provide 'setup-js)