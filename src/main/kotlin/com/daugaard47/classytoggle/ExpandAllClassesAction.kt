package com.daugaard47.classytoggle

import com.intellij.openapi.actionSystem.AnAction
import com.intellij.openapi.actionSystem.AnActionEvent
import com.intellij.openapi.actionSystem.CommonDataKeys

class ExpandAllClassesAction : AnAction() {
    override fun actionPerformed(e: AnActionEvent) {
        val editor = e.getRequiredData(CommonDataKeys.EDITOR)
        val foldingModel = editor.foldingModel
        foldingModel.runBatchFoldingOperation {
            for (region in foldingModel.allFoldRegions) {
                val placeholderText = region.placeholderText
                if (placeholderText.startsWith("...")) {
                    region.isExpanded = true
                }
            }
        }
    }
}
