package com.daugaard47.classytoggle

import com.intellij.codeInsight.folding.CodeFoldingManager
import com.intellij.openapi.actionSystem.AnAction
import com.intellij.openapi.actionSystem.AnActionEvent
import com.intellij.openapi.editor.Document
import com.intellij.openapi.editor.Editor
import com.intellij.openapi.project.Project

class CollapseAllClassesAction : AnAction() {
    override fun actionPerformed(e: AnActionEvent) {
        val project: Project = e.project ?: return
        val editor = e.getData(com.intellij.openapi.actionSystem.PlatformDataKeys.EDITOR) ?: return
        val document: Document = editor.document

        collapseClasses(editor, document, project)
    }

    private fun collapseClasses(editor: Editor, document: Document, project: Project) {
        val foldingManager = CodeFoldingManager.getInstance(project)
        foldingManager.updateFoldRegions(editor)

        val foldingModel = editor.foldingModel

        foldingModel.runBatchFoldingOperation {
            val text = document.text
            val regex = Regex("""class="([^"]+)"|class='([^']+)'""")
            regex.findAll(text).forEach { result ->
                val range = result.range
                val start = range.first
                val end = range.last
                val foldRegion = foldingModel.getFoldRegion(start, end + 1)
                if (foldRegion == null) {
                    foldingModel.addFoldRegion(start, end + 1, "...")
                } else {
                    foldRegion.isExpanded = false
                }
            }
        }
    }
}
